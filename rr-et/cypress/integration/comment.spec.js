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

describe('CommentController:', () => {
  beforeEach(() => {
    // Cypress starts out with a blank slate for each test
    // so we must tell it to visit our website with the `cy.visit()` command.
    // Since we want to visit the same URL at the start of all our tests,
    // we include it in our beforeEach function so that it runs before each test
    cy.refreshDatabase();
    cy.visit('/')
  })

  describe('General User(logged-in)', () => {
    it('can post a comment to a script', () => {
      cy.create('App\\Category', { name: 'IT' })
      registration_user()
      cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-1-comment-button"]').should('have.text', ' 0')
      cy.get('[data-e2e="script-1-comment-button"]').click()
      cy.get('[data-e2e="script-1-comment-form"]').type('それはないないです')
      cy.get('[data-e2e="script-1-comment-submit"]').click()
  
      cy.get('[data-e2e="script-1-comment-button"]').should('have.text', ' 1')
      cy.get('[data-e2e="script-1-comment-1"]').should('have.text', 'それはないないです')
    })

    it('can delete a comment', () => {
      cy.create('App\\Category', { name: 'IT' })
      registration_user()
      cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-1-comment-button"]').click()
      cy.get('[data-e2e="script-1-comment-form"]').type('それはないないです')
      cy.get('[data-e2e="script-1-comment-submit"]').click()
    })

    it('has a warning message to comment when script posted before changing script', () => {
      cy.create('App\\Category', { name: 'IT' })
      registration_user()
      cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-1-comment-button"]').should('have.text', ' 0')
      cy.get('[data-e2e="script-1-comment-button"]').click()
      cy.get('[data-e2e="script-1-comment-form"]').type('それはないないです')
      cy.get('[data-e2e="script-1-comment-submit"]').click()

      cy.get('[data-e2e="script-1-edit"]').click()
      cy.get('form').within(() => {
        cy.get('textarea[name="content"]').clear()
        cy.get('textarea[name="content"]').type('Laravelチョットワカル')
        cy.get('[data-e2e="submit"]').click()
      })

      cy.get('[data-e2e="script-1-comment-button"]').should('have.text', ' 1')
      cy.get('[data-e2e="script-1-comment-button"]').click()

      cy.get('[data-e2e="script-1-comment-1-warning"]').should('have.text', 'ネタ内容が変更される前のコメントです。')
    })
  })

  describe('Admin User(logged-in)', () => {
    it('can delete all general user comments', () => {
      cy.create('App\\Category', { name: 'IT' })
      registration_user()
      cy.create('App\\Script', { 
        content: 'Linuxチョットワカル',
        category_id: 1,
        user_id: 1,
      })
      cy.visit('/scripts')
      cy.get('[data-e2e="script-1-comment-button"]').should('have.text', ' 0')
      cy.get('[data-e2e="script-1-comment-button"]').click()
      cy.get('[data-e2e="script-1-comment-form"]').type('それはないないです')
      cy.get('[data-e2e="script-1-comment-submit"]').click()
      cy.get('[data-e2e="user-dropdown"]').click();
      cy.get('[data-e2e="user-dropdown"]').contains('ログアウト').click();

      const adminEmail = 'foo@example.com'
      const adminPassword = 'password'
      cy.seed('UsersTableSeeder');

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="email-input"]').type(adminEmail)
      cy.get('[data-e2e="password-input"]').type(adminPassword)
      cy.get('[data-e2e="submit"]').contains('ログイン').click()

      cy.get('[data-e2e="script-1-comment-button"]').click()
      cy.get('[data-e2e="script-1-comment-1-delete"]').click()
      cy.get('[data-e2e="script-1-comment-1"]').should('not.exist')
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