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
    cy.get('#lead-message').should('have.text', 'あるある、')
  });

  it('Registratable on register page', () => {
    cy.get('.container').contains('新規登録').click()
    cy.get('.card-header').should('have.text','新規登録')
    cy.get('[data-e2e="name-input"]').type('佐藤B作')
    cy.get('[data-e2e="email-input"]').type('satoh-besaku@example.com')
    cy.get('[data-e2e="password-input"]').type('password')
    cy.get('[data-e2e="password-confirm-input"]').type('password')
    cy.get('[data-e2e="submit"]').contains('登録').click()
    cy.get('h1').should('have.text', 'ネタ一覧')
  });
  
  it('Available to Login', () => {
    registration_user()
    cy.get('[data-e2e="user-dropdown"]').click();
    cy.get('[data-e2e="user-dropdown"]').contains('ログアウト').click();
    cy.get('.container').contains('ログイン').click()
    
    cy.get('.card-header').should('have.text','ログイン')
    cy.get('[data-e2e="email-input"]').type('satoh-besaku@example.com')
    cy.get('[data-e2e="password-input"]').type('password')
    cy.get('[data-e2e="submit"]').contains('ログイン').click()
    cy.get('h1').should('have.text', 'ネタ一覧')
  })
  
  it('Available to Login as Guest User', () => {
    cy.get('.container').contains('ゲストログイン').click()
    cy.get('h1').should('have.text', 'ネタ一覧')
    cy.get('[data-e2e="auth-status"]').should('have.text', 'Guest')
  })

  describe('Registrate validarion:', () => {
    beforeEach(() => {
      cy.get('.container').contains('新規登録').click()
      cy.get('[data-e2e="name-input"]').type('佐藤B作')
      cy.get('[data-e2e="email-input"]').type('satoh-besaku@example.com')
      cy.get('[data-e2e="password-input"]').type('password')
      cy.get('[data-e2e="password-confirm-input"]').type('password')
    })

    it('validator is working when name is empty', () => {
      cy.get('[data-e2e="name-input"]').clear()
      cy.get('[data-e2e="submit"]').click()
      cy.get('#name')
        .invoke('prop', 'validationMessage')
        .should('equal', 'このフィールドを入力してください。')
      cy.get('.card-header').should('have.text','新規登録')
    });

    it('validator is working when name is over 255 charactors', () => {
      const name = Cypress._.repeat('12345678', 32)
      cy.get('[data-e2e="name-input"]').clear()
      cy.get('[data-e2e="name-input"]').type(name)
      cy.get('[data-e2e="submit"]').click()
      cy.get('.card-header').should('have.text','新規登録')
      cy.get('[data-e2e="name-validate-message"]')
        .should('have.text', '名前は、255文字以下で入力してください。')
    });

    it('validator is working when email is empty', () => {
      cy.get('[data-e2e="email-input"]').clear()
      cy.get('[data-e2e="submit"]').click()
      cy.get('#email')
        .invoke('prop', 'validationMessage')
        .should('equal', 'このフィールドを入力してください。')
      cy.get('.card-header').should('have.text','新規登録')
    });

    it('validator is working when email is invalid', () => {
      const testEmail = [
        "user@example,com",
        "user_at_foo.org",
        "user.name@example."
      ]

      const errorMessage = [
        "「@」に続く文字列に記号「,」を使用しないでください。",
        "メール アドレスに「@」を挿入してください。「user_at_foo.org」内に「@」がありません。",
        "「example.」内の「.」の位置が間違っています。",
      ]

      for(let i = 0; i < testEmail.length - 1; i++){
        cy.get('[data-e2e="email-input"]').clear()
        cy.get('[data-e2e="email-input"]').type(testEmail[i])
        cy.get('[data-e2e="submit"]').click()
        cy.get('#email')
          .invoke('prop', 'validationMessage')
          .should('equal', errorMessage[i])
        cy.get('.card-header').should('have.text','新規登録')
      }
    });

    it('validator is working when password is empty', () => {
      cy.get('[data-e2e="password-input"]').clear()
      cy.get('[data-e2e="submit"]').click()
      cy.get('#password')
        .invoke('prop', 'validationMessage')
        .should('equal', 'このフィールドを入力してください。')
      cy.get('.card-header').should('have.text','新規登録')
    });

    it('validator is working when password has 1 charactor', () => {
      cy.get('[data-e2e="password-input"]').clear()
      cy.get('[data-e2e="password-input"]').type('p')
      cy.get('[data-e2e="submit"]').click()
      cy.get('[data-e2e="password-validate-message"]').should('have.text','パスワードは、8文字以上で入力してください。')
      cy.get('.card-header').should('have.text','新規登録')
    });

    it('validator is working when password has 7 charactors', () => {
      cy.get('[data-e2e="password-input"]').clear()
      cy.get('[data-e2e="password-input"]').type('passwor')
      cy.get('[data-e2e="submit"]').click()
      cy.get('[data-e2e="password-validate-message"]').should('have.text','パスワードは、8文字以上で入力してください。')
      cy.get('.card-header').should('have.text','新規登録')
    });

    it('validator is working when password has symbols', () => {
      cy.get('[data-e2e="password-input"]').clear()
      cy.get('[data-e2e="password-input"]').type('password#')
      cy.get('[data-e2e="submit"]').click()
      cy.get('[data-e2e="password-validate-message"]').should('have.text','パスワードは正しい形式で入力してください。')
      cy.get('.card-header').should('have.text','新規登録')
    });
    
    it('validator is working when password-confirm is empty', () => {
      cy.get('[data-e2e="password-confirm-input"]').clear()
      cy.get('[data-e2e="submit"]').click()
      cy.get('#password-confirm')
      .invoke('prop', 'validationMessage')
      .should('equal', 'このフィールドを入力してください。')
      cy.get('.card-header').should('have.text','新規登録')
    });
    
    it('validator is working when password-confirm and password are not same latter', () => {
      cy.get('[data-e2e="password-confirm-input"]').clear()
      cy.get('[data-e2e="password-confirm-input"]').type('passwords')
      cy.get('[data-e2e="submit"]').click()
      cy.get('[data-e2e="password-validate-message"]').should('have.text','パスワードと、再入力フィールドが、一致していません。')
      cy.get('.card-header').should('have.text','新規登録')
    });
    
    it('validator is working when password-confirm and password are not same latter', () => {
      cy.get('[data-e2e="password-confirm-input"]').clear()
      cy.get('[data-e2e="password-confirm-input"]').type('Password')
      cy.get('[data-e2e="submit"]').click()
      cy.get('[data-e2e="password-validate-message"]').should('have.text','パスワードと、再入力フィールドが、一致していません。')
      cy.get('.card-header').should('have.text','新規登録')
    });
  });
});

function registration_user() {
  cy.get('.container').contains('新規登録').click()
  cy.get('[data-e2e="name-input"]').type('佐藤B作')
  cy.get('[data-e2e="email-input"]').type('satoh-besaku@example.com')
  cy.get('[data-e2e="password-input"]').type('password')
  cy.get('[data-e2e="password-confirm-input"]').type('password')
  cy.get('[data-e2e="submit"]').contains('登録').click()
}