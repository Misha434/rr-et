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

describe('CategoryController:', () => {
  beforeEach(() => {
    // Cypress starts out with a blank slate for each test
    // so we must tell it to visit our website with the `cy.visit()` command.
    // Since we want to visit the same URL at the start of all our tests,
    // we include it in our beforeEach function so that it runs before each test
    cy.refreshDatabase();
    cy.visit('/')
  })

  describe('Not-login User', () => {
    it('are required to access categories#index page', () => {
      cy.get('header').contains('カテゴリー').click()
      cy.get('.card-header').should('have.text', 'ログイン')
    })
  })

  describe('General User(logged-in)', () => {
    it('can access to access categories#index page', () => {
      cy.create('App\\Category', { name: 'IT' })
      registration_user()
      cy.visit('/')
      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="category-0"]').should('have.text', 'IT')
    })
    
    it('can access to access categories#show page', () => {
      registration_user()
      cy.create('App\\Category', { name: 'IT' })
      cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })
      cy.visit('/')
      
      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="category-0"]').click()
      cy.get('[data-e2e="script-0"]').should('have.text', 'Linuxチョットワカル')
    })
    
    it('cannot access to categories#create page', () => {
      registration_user()
      
      const categoriesCreatePageUrl = '/categories/create'
      cy.request({
        url: categoriesCreatePageUrl,
        followRedirect: false,
        failOnStatusCode: false,
      }).then((resp) => {
        expect(resp.status).to.eq(403)
      })
      cy.visit(categoriesCreatePageUrl, { failOnStatusCode: false })
      cy.get("h1").should("contain", "403 Forbidden")
    })
    
    it('cannot access to categories#edit page', () => {
      cy.create('App\\Category', { name: 'IT' })
      registration_user()
      
      const categoriesEditPageUrl = '/categories/1/edit'
      cy.request({
        url: categoriesEditPageUrl,
        followRedirect: false,
        failOnStatusCode: false,
      }).then((resp) => {
        expect(resp.status).to.eq(403)
      })
      cy.visit(categoriesEditPageUrl, { failOnStatusCode: false })
      cy.get("h1").should("contain", "403 Forbidden")
    })
  })
  
  describe('Admin User(logged-in)', () => {
    it('can access to access categories#index page', () => {
      const adminEmail = 'foo@example.com'
      const adminPassword = 'password'
      
      cy.create('App\\Category', { name: 'IT' })
      cy.seed('UsersTableSeeder');

      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="email-input"]').type(adminEmail)
      cy.get('[data-e2e="password-input"]').type(adminPassword)
      cy.get('[data-e2e="submit"]').contains('ログイン').click()

      cy.get('[data-e2e="category-0"]').should('have.text', 'IT')
      cy.get('.card').should('contain', '編集')
    })
    
    it('can access to access categories#show page', () => {
      const adminEmail = 'foo@example.com'
      const adminPassword = 'password'
      
      cy.create('App\\Category', { name: 'IT' })
      cy.seed('UsersTableSeeder');
      cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })

      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="email-input"]').type(adminEmail)
      cy.get('[data-e2e="password-input"]').type(adminPassword)
      cy.get('[data-e2e="submit"]').contains('ログイン').click()

      cy.get('[data-e2e="category-0"]').click()
      cy.get('h1').should('have.text', 'IT')
      
      cy.get('[data-e2e="script-0"]').should('have.text', 'Linuxチョットワカル')
    })
    
    it('is available to create a category in categories#create page', () => {
      const adminEmail = 'foo@example.com'
      const adminPassword = 'password'
      
      cy.seed('UsersTableSeeder');
      
      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="email-input"]').type(adminEmail)
      cy.get('[data-e2e="password-input"]').type(adminPassword)
      cy.get('[data-e2e="submit"]').contains('ログイン').click()
      
      cy.visit('/categories/create')
      cy.get('h1').should('have.text', 'カテゴリー追加')
      cy.get('[data-e2e="category-input"]').type('音楽')
      cy.get('[data-e2e="submit"]').contains('送信').click()
      cy.get('[data-e2e="category-0"]').should('have.text', '音楽')
    })
    
    it('can access to categories#edit page', () => {
      const adminEmail = 'foo@example.com'
      const adminPassword = 'password'
      
      cy.create('App\\Category', { name: 'IT' })
      cy.seed('UsersTableSeeder');
      cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })
      
      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="email-input"]').type(adminEmail)
      cy.get('[data-e2e="password-input"]').type(adminPassword)
      cy.get('[data-e2e="submit"]').contains('ログイン').click()
      
      cy.visit('/categories/1/edit')
      cy.get('h1').should('have.text', 'カテゴリー編集')
      cy.get('[data-e2e="category-input"]').clear()
      cy.get('[data-e2e="category-input"]').type('音楽')
      cy.get('[data-e2e="submit"]').contains('送信').click()
      cy.get('[data-e2e="category-0"]').should('have.text', '音楽')
    })
    
    it('can delete the category in categories#index page', () => {
      const adminEmail = 'foo@example.com'
      const adminPassword = 'password'
      
      cy.create('App\\Category', { name: 'IT' })
      cy.create('App\\Category', { name: '音楽' })
      cy.seed('UsersTableSeeder');
      
      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="email-input"]').type(adminEmail)
      cy.get('[data-e2e="password-input"]').type(adminPassword)
      cy.get('[data-e2e="submit"]').contains('ログイン').click()

      cy.get('[data-e2e="category-0"]').should('have.text', 'IT')
      cy.get('[data-e2e="category-1"]').should('have.text', '音楽')
      
      cy.get('[data-e2e="category-0-delete"]').contains('削除').click()
      cy.get('[data-e2e="category-0"]').not('have.text', 'IT')
      cy.get('[data-e2e="category-0"]').should('have.text', '音楽')
    })
  })
})

function registration_user() {
  cy.get('.container').contains('新規登録').click()
  cy.get('[data-e2e="name-input"]').type('佐藤B作')
  cy.get('[data-e2e="email-input"]').type('satoh-besaku@example.com')
  cy.get('[data-e2e="password-input"]').type('password')
  cy.get('[data-e2e="password-confirm-input"]').type('password')
  cy.get('[data-e2e="submit"]').contains('登録').click()
}