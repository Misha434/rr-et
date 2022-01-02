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

  it('Available Login page', () => {
    cy.get('.container').contains('ログイン').click()
    cy.get('.card-header').should('have.text','ログイン')
  });

  it('Available Signup page', () => {
    cy.get('.container').contains('新規登録').click()
    cy.get('.card-header').should('have.text','新規登録')
  });
})
