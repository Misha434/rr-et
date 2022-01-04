/// <reference types="cypress" />

// Welcome to Cypress!
//
// This spec file contains a variety of sample tests
// for a todo list app that are designed to demonstrate
// the power of writing tests in Cypress.
//
// To learn more about how Cypress works and
// what makes it such an awesome testing tool,
// please read our getting started guide:
// https://on.cypress.io/introduction-to-cypress

describe('ScriptController:', () => {
  beforeEach(() => {
    // Cypress starts out with a blank slate for each test
    // so we must tell it to visit our website with the `cy.visit()` command.
    // Since we want to visit the same URL at the start of all our tests,
    // we include it in our beforeEach function so that it runs before each test
    cy.refreshDatabase();
    cy.visit('/')
  })

  describe('Not-login User', () => {
    it('are required login to access scripts#index page', () => {
      cy.get('header').contains('ネタ一覧').click()
      cy.get('.card-header').should('have.text', 'ログイン')
    })
  })

  describe('General User(logged-in)', () => {
    it('can access to access scripts#index page', () => {
      cy.create('App\\Category', { name: 'IT' })
      registration_user()
      cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })

      cy.visit('/')
      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-0"]').should('have.text', 'Linuxチョットワカル')
      cy.get('[data-e2e="script-0-username"]').should('have.text', '佐藤B作')
    })
    
    // it('can access to access scripts#show page', () => {
    //   registration_user()
    //   cy.create('App\\Category', { name: 'IT' })
    //   cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })
    //   cy.visit('/')

    //   cy.get('header').contains('カテゴリー').click()
    //   cy.get('[data-e2e="category-0"]').click()
    //   cy.get('[data-e2e="script-0"]').should('have.text', 'Linuxチョットワカル')
    // })

    it('can post a script on scripts#create page', () => {
      cy.create('App\\Category', { name: 'IT' })
      cy.create('App\\Category', { name: '音楽' })
      registration_user()

      cy.get('[data-e2e="user-dropdown"]').click()
      cy.get('.dropdown-item').contains('ネタ新規投稿').click()
      cy.get('h1').should('have.text', 'あるあるを投稿しましょう!')
      
      cy.get('form').within(() => {
        cy.get('select').select('IT')
        cy.get('textarea[name="content"]').type('Linuxチョットワカル')
        cy.get('[data-e2e="submit"]').click()
      })
      cy.get('[data-e2e="script-0"]').should('have.text', 'Linuxチョットワカル')
    })

    it('can edit posted script to scripts#edit page', () => {
      registration_user()
      cy.create('App\\Category', { name: 'IT' })
      cy.create('App\\Script', { 
        content: 'Linuxチョットワカル',
        category_id: 1,
        user_id: 1,
      })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-0-edit"]').click()
      cy.get('h1').should('have.text', 'あるあるを編集しましょう!')
      cy.get('form').within(() => {
        cy.get('option:selected').should('have.text', 'IT')
        cy.get('textarea[name="content"]').should('have.text', 'Linuxチョットワカル')
        cy.get('textarea[name="content"]').clear()
        cy.get('textarea[name="content"]').type('Linux完全に理解した')
        cy.get('[data-e2e="submit"]').click()
      })
      cy.get('[data-e2e="script-0"]').should('have.text', 'Linux完全に理解した')
    })

    it('cannot access to scripts#edit page by other user', () => {
      cy.seed('UsersTableSeeder');
      cy.seed('CategoriesTableSeeder');
      cy.seed('ScriptsTableSeeder');
      registration_user()
      
      cy.visit('/scripts/1/edit')
      cy.get("h1").should("contain", "ネタ一覧")
    })

    it('can delete the script in scripts#index page', () => {
      registration_user()
      cy.create('App\\Category', { name: 'IT' })
      cy.create('App\\Script', { 
        content: 'Linuxチョットワカル',
        category_id: 1,
        user_id: 1,
      })
      cy.create('App\\Script', { 
        content: 'Linux完全に理解した',
        category_id: 1,
        user_id: 1,
      })
      
      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-0-delete"]').click()

      cy.get('[data-e2e="script-0"]').not('have.text', 'Linuxチョットワカル')
      cy.get('[data-e2e="script-0"]').should('have.text', 'Linux完全に理解した')
    })

    it('can search the script in scripts#index page', () => {
      registration_user()
      cy.create('App\\Category', { name: 'IT' })
      cy.create('App\\Script', { 
        content: 'Linuxチョットワカル',
        category_id: 1,
        user_id: 1,
      })
      cy.create('App\\Script', { 
        content: 'Linux完全に理解した',
        category_id: 1,
        user_id: 1,
      })
      cy.create('App\\Script', { 
        content: 'GitHub落ちたから仕事にならん',
        category_id: 1,
        user_id: 1,
      })
      cy.create('App\\Script', { 
        content: '大量のRedbullの差し入れ',
        category_id: 1,
        user_id: 1,
      })
      
      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-search-form"]').type('Linux')
      cy.get('[data-e2e="script-search-submit"]').click()
      
      cy.get('[data-e2e="script-search-count"]').should('have.text', '2 件')
      cy.get('[data-e2e="script-0"]').should('have.text', 'Linuxチョットワカル')
      cy.get('[data-e2e="script-1"]').should('have.text', 'Linux完全に理解した')
    })

    it('can search the script but showing not found', () => {
      registration_user()
      cy.create('App\\Category', { name: 'IT' })
      cy.create('App\\Script', { 
        content: 'Linuxチョットワカル',
        category_id: 1,
        user_id: 1,
      })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-search-form"]').type('Ubuntu')
      cy.get('[data-e2e="script-search-submit"]').click()
      
      cy.get('[data-e2e="script-search-not-found"]').should('have.text', '見つかりませんでした。')
    })
  })
  
  describe('Admin User(logged-in)', () => {
    it('can delete itself user post', () => {
      const adminEmail = 'foo@example.com'
      const adminPassword = 'password'
      cy.seed('UsersTableSeeder');

      cy.create('App\\Category', { name: 'IT' })
      cy.create('App\\Script', { 
        content: 'Linuxチョットワカル',
        category_id: 1,
        user_id: 1,
      })
      cy.create('App\\Script', { 
        content: 'Linux完全に理解した',
        category_id: 1,
        user_id: 2,
      })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="email-input"]').type(adminEmail)
      cy.get('[data-e2e="password-input"]').type(adminPassword)
      cy.get('[data-e2e="submit"]').contains('ログイン').click()

      cy.get('[data-e2e="script-0"]').should('have.text', 'Linuxチョットワカル')
      cy.get('[data-e2e="script-1"]').should('have.text', 'Linux完全に理解した')
      
      cy.get('[data-e2e="script-0-delete"]').click()
      cy.get('[data-e2e="script-0"]').not('have.text', 'Linuxチョットワカル')
      cy.get('[data-e2e="script-0"]').should('have.text', 'Linux完全に理解した')
    })
  })
    
  //   it('can access to access scripts#show page', () => {
  //     const adminEmail = 'foo@example.com'
  //     const adminPassword = 'password'
      
  //     cy.create('App\\Category', { name: 'IT' })
  //     cy.seed('UsersTableSeeder');
  //     cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })

  //     cy.get('header').contains('カテゴリー').click()
  //     cy.get('[data-e2e="email-input"]').type(adminEmail)
  //     cy.get('[data-e2e="password-input"]').type(adminPassword)
  //     cy.get('[data-e2e="submit"]').contains('ログイン').click()

  //     cy.get('[data-e2e="category-0"]').click()
  //     cy.get('h1').should('have.text', 'IT')
      
  //     cy.get('[data-e2e="script-0"]').should('have.text', 'Linuxチョットワカル')
  //   })
    
  //   it('is available to create a category in scripts#create page', () => {
  //     const adminEmail = 'foo@example.com'
  //     const adminPassword = 'password'
      
  //     cy.seed('UsersTableSeeder');
      
  //     cy.get('header').contains('カテゴリー').click()
  //     cy.get('[data-e2e="email-input"]').type(adminEmail)
  //     cy.get('[data-e2e="password-input"]').type(adminPassword)
  //     cy.get('[data-e2e="submit"]').contains('ログイン').click()
      
  //     cy.visit('/scripts/create')
  //     cy.get('h1').should('have.text', 'カテゴリー追加')
  //     cy.get('[data-e2e="category-input"]').type('音楽')
  //     cy.get('[data-e2e="submit"]').contains('送信').click()
  //     cy.get('[data-e2e="category-0"]').should('have.text', '音楽')
  //   })
    
  //   it('can access to scripts#edit page', () => {
  //     const adminEmail = 'foo@example.com'
  //     const adminPassword = 'password'

  //     cy.create('App\\Category', { name: 'IT' })
  //     cy.seed('UsersTableSeeder');
  //     cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })
      
  //     cy.get('header').contains('カテゴリー').click()
  //     cy.get('[data-e2e="email-input"]').type(adminEmail)
  //     cy.get('[data-e2e="password-input"]').type(adminPassword)
  //     cy.get('[data-e2e="submit"]').contains('ログイン').click()
      
  //     cy.visit('/scripts/1/edit')
  //     cy.get('h1').should('have.text', 'カテゴリー編集')
  //     cy.get('[data-e2e="category-input"]').clear()
  //     cy.get('[data-e2e="category-input"]').type('音楽')
  //     cy.get('[data-e2e="submit"]').contains('送信').click()
  //     cy.get('[data-e2e="category-0"]').should('have.text', '音楽')
  //   })
    
  //   it('can delete the category in scripts#index page', () => {
  //     const adminEmail = 'foo@example.com'
  //     const adminPassword = 'password'
      
  //     cy.create('App\\Category', { name: 'IT' })
  //     cy.create('App\\Category', { name: '音楽' })
  //     cy.seed('UsersTableSeeder');
      
  //     cy.get('header').contains('カテゴリー').click()
  //     cy.get('[data-e2e="email-input"]').type(adminEmail)
  //     cy.get('[data-e2e="password-input"]').type(adminPassword)
  //     cy.get('[data-e2e="submit"]').contains('ログイン').click()

  //     cy.get('[data-e2e="category-0"]').should('have.text', 'IT')
  //     cy.get('[data-e2e="category-1"]').should('have.text', '音楽')
      
  //     cy.get('[data-e2e="category-0-delete"]').contains('削除').click()
  //     cy.get('[data-e2e="category-0"]').not('have.text', 'IT')
  //     cy.get('[data-e2e="category-0"]').should('have.text', '音楽')
  //   })
  // })
})

function registration_user() {
  cy.get('.container').contains('新規登録').click()
  cy.get('[data-e2e="name-input"]').type('佐藤B作')
  cy.get('[data-e2e="email-input"]').type('satoh-besaku@example.com')
  cy.get('[data-e2e="password-input"]').type('password')
  cy.get('[data-e2e="password-confirm-input"]').type('password')
  cy.get('[data-e2e="submit"]').contains('登録').click()
}