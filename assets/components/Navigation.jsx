import { createSignal } from "solid-js";
import {
  Navbar,
  Container,
  Nav,
  NavDropdown,
  Form,
  FormControl,
  Button,
} from "solid-bootstrap";
import BootstrapColorsDebugDropdown from "./BootstrapColorsDebugDropdown";

export default function Navigation() {
  const [links, setLinks] = createSignal({});
  const [debug, setDebug] = createSignal(false);
  const [admin, setAdmin] = createSignal(false);
  const [user, setUser] = createSignal(false);

  const AdminNavItem = function (props) {
    return <Nav.Link href={props.link}>Admin</Nav.Link>;
  };

  const GuestNavbar = function (props) {
    // @TODO: implement Guest buttons: Sign Up, Sign In
    return "";
  };

  const UserNavbar = function (props) {
    // @TODO: Implement User buttons: Logout
    return "";
  };

  return (
    <Navbar bg="light" expand="lg">
      <Container>
        <Navbar.Brand href="/">Gamer Reviews</Navbar.Brand>
        <Navbar.Toggle aria-controls="basic-navbar-nav" />
        <Navbar.Collapse id="basic-navbar-nav">
          <Nav class="me-auto mb-2 mb-lg-0">
            {debug() && <BootstrapColorsDebugDropdown />}
            {admin() && <AdminNavItem />}
          </Nav>
          <Nav class="mb-2 mb-lg-0">
            <Form class="d-flex form-inline">
              <Form.Control
                type="search"
                placeholder="Search"
                class="me-2 search-input"
                aria-label="Search"
              />
              <Button variant="outline-primary" class="search-button me-2">
                Search
              </Button>
            </Form>
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}
