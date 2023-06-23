import React, { useEffect, useState } from "react";
import Game from "./Game";
import fetchGames from "../api/fetchGames";

export default function Games() {
  const [games, setGames] = useState([]);

  useEffect(() => {
    let ignore = false;

    async function startFetching() {
      const games = await fetchGames();

      if (!ignore) {
        setGames(games);
      }
    }

    startFetching();

    return () => {
      ignore = true;
    };
  }, []);

  const listItems = games.map((game) => <Game game={game} key={game.id} />);

  return <ul>{listItems}</ul>;
}
