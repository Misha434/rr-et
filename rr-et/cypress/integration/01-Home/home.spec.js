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

describe('HomeController:', () => {
  beforeEach(() => {
    // Cypress starts out with a blank slate for each test
    // so we must tell it to visit our website with the `cy.visit()` command.
    // Since we want to visit the same URL at the start of all our tests,
    // we include it in our beforeEach function so that it runs before each test
    cy.refreshDatabase();
    cy.visit('/')
  })

  it('Available Home page', () => {
    cy.get('#lead-message').should('have.text', 'あるある、');
  });

  it('Registratable on register page', () => {
    cy.get('.container').contains('新規登録').click()
    cy.get('.card-header').should('have.text','新規登録')
    cy.get('[data-e2e="name-input"]').type('佐藤B作')
    cy.get('[data-e2e="email-input"]').type('satoh-besaku@example.com')
    cy.get('[data-e2e="password-input"]').type('password')
    cy.get('[data-e2e="password-comfirm-input"]').type('password')
    cy.get('[data-e2e="submit"]').contains('登録').click();
    cy.get('h1').should('have.text', 'ネタ一覧')
  });

  it('Available to Login', () => {
    cy.get('.container').contains('ログイン').click()
    cy.get('.card-header').should('have.text','ログイン')
  });
})

function registration_user() {
  cy.get('.container').contains('新規登録').click()
  cy.get('[data-e2e="name-input"]').type('佐藤B作')
  cy.get('[data-e2e="email-input"]').type('satoh-besaku@example.com')
  cy.get('[data-e2e="password-input"]').type('password')
  cy.get('[data-e2e="password-comfirm-input"]').type('password')
  cy.get('[data-e2e="submit"]').contains('登録').click();
}