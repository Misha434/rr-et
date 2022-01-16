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

describe('LikeController:', () => {
  beforeEach(() => {
    // Cypress starts out with a blank slate for each test
    // so we must tell it to visit our website with the `cy.visit()` command.
    // Since we want to visit the same URL at the start of all our tests,
    // we include it in our beforeEach function so that it runs before each test
    cy.refreshDatabase();
    cy.visit('/')
  })

  describe('General User(logged-in)', () => {
    it('can use like button', () => {
      cy.create('App\\Category', { name: 'IT' })
      registration_user()
      cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-1-like-count"]').should('have.text', '0')
      cy.get('[data-e2e="script-1-like"]').click()
      cy.get('[data-e2e="script-1-like-count"]').should('have.text', '1')

    })

    it('can use release-like button', () => {
      cy.create('App\\Category', { name: 'IT' })
      registration_user()
      cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-1-like"]').click()
      cy.get('[data-e2e="script-1-like-count"]').should('have.text', '1')

      cy.get('[data-e2e="script-1-like"]').click()
      cy.get('[data-e2e="script-1-like-count"]').should('have.text', '0')
    })

    it('cannot click like button with doubled', () => {
      cy.create('App\\Category', { name: 'IT' })
      registration_user()
      cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-1-like"]').dblclick()
      
      cy.get('[data-e2e="script-1-like-count"]').should('have.text', '1')
    })

    it('cannot click like button with doubled', () => {
      cy.create('App\\Category', { name: 'IT' })
      registration_user()
      cy.create('App\\Script', { content: 'Linuxチョットワカル', user_id: 1,category_id: 1 })

      cy.get('header').contains('ネタ一覧').click()
      cy.get('[data-e2e="script-1-like"]').click()
      cy.get('[data-e2e="script-1-like"]').dblclick()

      cy.get('[data-e2e="script-1-like-count"]').should('have.text', '0')
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