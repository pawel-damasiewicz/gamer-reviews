import React from "react";
import PropTypes from "prop-types";

function Game({ game }) {
  const gameLink = "/game/" + game.id;

  return (
    <a href={gameLink} className="list-group-item">
      <div className="mb-3">
        <div className="row g-0">
          <div className="col-md-2"></div>
          <div className="col-md-8">
            <h5>{game.name}</h5>
          </div>
        </div>
      </div>
    </a>
  );
}

Game.propTypes = {
  game: PropTypes.object,
};

export default Game;
