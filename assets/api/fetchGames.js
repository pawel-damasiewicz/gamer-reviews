export default async function fetchGames() {
  const response = await fetch("/api/game");

  return response.json();
}
