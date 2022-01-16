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

describe('ProposalController:', () => {
  beforeEach(() => {
    // Cypress starts out with a blank slate for each test
    // so we must tell it to visit our website with the `cy.visit()` command.
    // Since we want to visit the same URL at the start of all our tests,
    // we include it in our beforeEach function so that it runs before each test
    cy.refreshDatabase();
    cy.visit('/')
  })

  describe('General User(logged-in)', () => {
    it('can access to proposals#create page', () => {
      registration_user()
      visit_proposal_create()
      cy.get('h1').should('have.text', 'カテゴリー提案')
      post_proposal()

      cy.get('h1').should('have.text', 'ネタ一覧')
    })
  })
  
  describe('Admin User(logged-in)', () => {
    it('can access to access proposals#index page', () => {
      registration_user()
      visit_proposal_create()
      post_proposal()
      logout_user()

      cy.seed('UsersTableSeeder');

      const adminEmail = 'foo@example.com'
      const adminPassword = 'password'      

      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="email-input"]').type(adminEmail)
      cy.get('[data-e2e="password-input"]').type(adminPassword)
      cy.get('[data-e2e="submit"]').contains('ログイン').click()

      cy.get('[data-e2e="user-dropdown"]').click();
      cy.get('[data-e2e="user-dropdown"]').contains('カテゴリー提案一覧').click()

      cy.get('h1').should('have.text', 'カテゴリー提案一覧');
      cy.get('[data-e2e="proposal-1"]').should('have.text', '音楽')
    })
    
    it('can aprove to proposal', () => {
      registration_user()
      visit_proposal_create()
      post_proposal()
      logout_user()

      cy.seed('UsersTableSeeder');

      const adminEmail = 'foo@example.com'
      const adminPassword = 'password'      

      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="email-input"]').type(adminEmail)
      cy.get('[data-e2e="password-input"]').type(adminPassword)
      cy.get('[data-e2e="submit"]').contains('ログイン').click()

      cy.get('[data-e2e="user-dropdown"]').click();
      cy.get('[data-e2e="user-dropdown"]').contains('カテゴリー提案一覧').click()

      cy.get('h1').should('have.text', 'カテゴリー提案一覧');
      cy.get('[data-e2e="proposal-1"]').should('have.text', '音楽')
      cy.get('[data-e2e="proposal-1-aprove"]').click()

      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="category-1"]').should('have.text', '音楽')
    })
    
    it('can reject to proposal', () => {
      registration_user()
      visit_proposal_create()
      post_proposal()
      logout_user()

      cy.seed('UsersTableSeeder');

      const adminEmail = 'foo@example.com'
      const adminPassword = 'password'      

      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="email-input"]').type(adminEmail)
      cy.get('[data-e2e="password-input"]').type(adminPassword)
      cy.get('[data-e2e="submit"]').contains('ログイン').click()

      cy.get('[data-e2e="user-dropdown"]').click();
      cy.get('[data-e2e="user-dropdown"]').contains('カテゴリー提案一覧').click()

      cy.get('h1').should('have.text', 'カテゴリー提案一覧');
      cy.get('[data-e2e="proposal-1"]').should('have.text', '音楽')
      cy.get('[data-e2e="proposal-1-delete"]').click()

      cy.get('header').contains('カテゴリー').click()
      cy.get('[data-e2e="category-1"]').should('not.exist')
    })
  })
})

const registration_user = () => {
  cy.get('.container').contains('新規登録').click()
  cy.get('[data-e2e="name-input"]').type('佐藤B作')
  cy.get('[data-e2e="email-input"]').type('satoh-besaku@example.com')
  cy.get('[data-e2e="password-input"]').type('password')
  cy.get('[data-e2e="password-confirm-input"]').type('password')
  cy.get('[data-e2e="submit"]').contains('登録').click()
}

const visit_proposal_create = () => {
  cy.get('header').contains('カテゴリー').click()
  cy.get('[data-e2e="proposal-link"]').click()
}

const post_proposal = () => {
  cy.get('[data-e2e="category-input"]').type('音楽')
  cy.get('[data-e2e="submit"]').contains('送信').click()
}

const logout_user = () => {
  cy.get('[data-e2e="user-dropdown"]').click();
  cy.get('[data-e2e="user-dropdown"]').contains('ログアウト').click();
}