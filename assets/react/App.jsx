import React from "react";
import Container from "react-bootstrap/Container";
import Navigation from "./Navigation";
import Games from "./Games";

export default function App() {
  return (
    <Container>
      <Navigation />
      <header className="row">
        <h1>Games</h1>
      </header>
      <section className="row">
        <Games />
      </section>
    </Container>
  );
}
