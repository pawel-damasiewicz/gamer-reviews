import Navigation from "./Navigation";
import Home from "./Home";
import { Routes, Route } from "@solidjs/router";

export default function App() {
  return (
    <>
      <Navigation />
      <Routes>
        <Route path="/" component={Home} />
      </Routes>
    </>
  );
}
