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

describe('DraftController:', () => {
  beforeEach(() => {
    // Cypress starts out with a blank slate for each test
    // so we must tell it to visit our website with the `cy.visit()` command.
    // Since we want to visit the same URL at the start of all our tests,
    // we include it in our beforeEach function so that it runs before each test
    cy.refreshDatabase();
    cy.visit('/')
  })

  describe('General User(logged-in)', () => {
    it('can post a script with draft mode in scripts#create page ', () => {
      cy.create('App\\Category', { name: 'IT' })
      cy.create('App\\Category', { name: '音楽' })
      registration_user()

      cy.get('[data-e2e="user-dropdown"]').click()
      cy.get('.dropdown-item').contains('ネタ新規投稿').click()
      cy.get('h1').should('have.text', 'あるあるを投稿しましょう!')

      cy.get('form').within(() => {
        cy.get('select').select('IT')
        cy.get('textarea[name="content"]').type('Linuxチョットワカル')
        cy.get('[data-e2e="draft"]').click()
      })

      cy.get('[data-e2e="script-1"]').should('not.exist')

      cy.get('[data-e2e="user-dropdown"]').click()
      cy.get('.dropdown-item').contains('ネタ下書き').click()

      cy.get('h1').should('have.text', '下書き一覧')
      cy.get('[data-e2e="script-1"]').should('have.text', 'Linuxチョットワカル')
    })

    it('can change to draft mode for posted script in scripts#edit page', () => {
      registration_user()
      cy.create('App\\Category', { name: 'IT' })
      cy.create('App\\Script', { 
        content: 'Linuxチョットワカル',
        category_id: 1,
        user_id: 1,
      })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-1-edit"]').click()

      cy.get('h1').should('have.text', 'あるあるを編集しましょう!')
      cy.get('form').within(() => {
        cy.get('[data-e2e="draft"]').click()
      })
      cy.get('[data-e2e="script-1"]').should('not.exist')

      cy.get('[data-e2e="user-dropdown"]').click()
      cy.get('.dropdown-item').contains('ネタ下書き').click()

      cy.get('h1').should('have.text', '下書き一覧')
      cy.get('[data-e2e="script-1"]').click()

      cy.get('h1').should('have.text', 'あるあるを編集しましょう!')
      cy.get('form').within(() => {
        cy.get('option:selected').should('have.text', 'IT')
        cy.get('textarea[name="content"]').should('have.text', 'Linuxチョットワカル')
      })
    })

    it('can delete draft script in drafts#index page', () => {
      registration_user()
      cy.create('App\\Category', { name: 'IT' })
      cy.create('App\\Script', { 
        content: 'Linuxチョットワカル',
        category_id: 1,
        user_id: 1,
      })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-1-edit"]').click()

      cy.get('h1').should('have.text', 'あるあるを編集しましょう!')
      cy.get('form').within(() => {
        cy.get('[data-e2e="draft"]').click()
      })

      cy.get('[data-e2e="user-dropdown"]').click()
      cy.get('.dropdown-item').contains('ネタ下書き').click()

      cy.get('h1').should('have.text', '下書き一覧')
      cy.get('[data-e2e="script-1-delete"]').click()

      cy.get('[data-e2e="user-dropdown"]').click()
      cy.get('.dropdown-item').contains('ネタ下書き').click()

      cy.get('[data-e2e="script-1"]').should('not.exist')
    })

  // describe('Admin User(logged-in)', () => {
  //   it('can delete itself user post', () => {
  //     const adminEmail = 'foo@example.com'
  //     const adminPassword = 'password'
  //     cy.seed('UsersTableSeeder');

  //     cy.create('App\\Category', { name: 'IT' })
  //     cy.create('App\\Script', { 
  //       content: 'Linuxチョットワカル',
  //       category_id: 1,
  //       user_id: 1,
  //     })
  //     cy.create('App\\Script', { 
  //       content: 'Linux完全に理解した',
  //       category_id: 1,
  //       user_id: 2,
  //     })

  //     cy.get('header').contains('ネタ一覧').click()
  //     cy.get('[data-e2e="email-input"]').type(adminEmail)
  //     cy.get('[data-e2e="password-input"]').type(adminPassword)
  //     cy.get('[data-e2e="submit"]').contains('ログイン').click()

  //     cy.get('[data-e2e="script-1"]').should('have.text', 'Linuxチョットワカル')
  //     cy.get('[data-e2e="script-2"]').should('have.text', 'Linux完全に理解した')
      
  //     cy.get('[data-e2e="script-1-delete"]').click()
  //     cy.get('[data-e2e="script-1"]').should('not.exist')
  //     cy.get('[data-e2e="script-2"]').should('have.text', 'Linux完全に理解した')
  //   })
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