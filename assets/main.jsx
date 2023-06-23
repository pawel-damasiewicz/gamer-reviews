import { render } from "solid-js/web";
import { Router } from "@solidjs/router";
import App from "./components/App";

render(function () {
  return (
    <Router>
      <App />
    </Router>
  );
}, document.getElementById("app"));
