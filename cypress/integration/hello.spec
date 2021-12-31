it('It can see Homepage', () => {
  cy.visit('/')

  cy.get("#lead-message").should("have.text", "あるある。")
  }
)