import { NavDropdown } from "solid-bootstrap";

export default function BootstrapColorsDebugDropdown() {
  return (
    <NavDropdown title="Bootstrap Clolor Check" id="basic-nav-dropdown">
      <NavDropdown.Item class="bg-primary" href="#primary">
        Primary
      </NavDropdown.Item>
      <NavDropdown.Item class="bg-secondary" href="#secondary">
        Secondary
      </NavDropdown.Item>
      <NavDropdown.Item class="bg-success" href="#success">
        Success
      </NavDropdown.Item>
      <NavDropdown.Item class="bg-info" href="#info">
        Info
      </NavDropdown.Item>
      <NavDropdown.Item class="bg-warning" href="#warning">
        Warning
      </NavDropdown.Item>
      <NavDropdown.Item class="bg-danger" href="#danger">
        Danger
      </NavDropdown.Item>
      <NavDropdown.Item class="bg-light" href="#light">
        Light
      </NavDropdown.Item>
      <NavDropdown.Item class="bg-dark" href="#dark">
        Dark
      </NavDropdown.Item>
    </NavDropdown>
  );
}
