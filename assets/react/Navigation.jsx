import React from "react";
import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";
import NavDropdown from "react-bootstrap/NavDropdown";

export default function Navigation() {
  return (
    <Navbar expand="lg" className="bg-light">
      <Container>
        <Navbar.Brand href="#home">Gamer Reviews</Navbar.Brand>
        <Navbar.Toggle aria-controls="basic-navbar-nav" />
        <Navbar.Collapse id="basic-navbar-nav">
          <Nav className="me-auto">
            <Nav.Link href="/">Home</Nav.Link>
            <NavDropdown title="Dropdown" id="basic-nav-dropdown">
              <NavDropdown.Item className="bg-primary" href="#primary">
                Primary
              </NavDropdown.Item>
              <NavDropdown.Item className="bg-secondary" href="#secondary">
                Secondary
              </NavDropdown.Item>
              <NavDropdown.Item className="bg-success" href="#success">
                Success
              </NavDropdown.Item>
              <NavDropdown.Item className="bg-info" href="#info">
                Info
              </NavDropdown.Item>
              <NavDropdown.Item className="bg-warning" href="#warning">
                Warning
              </NavDropdown.Item>
              <NavDropdown.Item className="bg-danger" href="#danger">
                Danger
              </NavDropdown.Item>
              <NavDropdown.Item className="bg-light" href="#light">
                Light
              </NavDropdown.Item>
              <NavDropdown.Item className="bg-dark" href="#dark">
                Dark
              </NavDropdown.Item>
            </NavDropdown>
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}
