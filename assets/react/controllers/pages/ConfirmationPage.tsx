import React, { lazy, useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import "../style/confirmation.scss";
import houseSvg from "../images/svg/house.svg";

export default function ConfirmationPage() {
  const [isConfirmed, setIsConfirmed] = useState(false);
  const [errorMessage, setErrorMessage] = useState("");
  const navigate = useNavigate();
  const sessionMail = sessionStorage.getItem("email");

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(`api/validate`, {
          method: "POST",
          headers: {
            "Content-type": "application/json",
          },
          body: JSON.stringify({ email: sessionMail })
        });

        if (response.ok) {
          navigate("/login");
        }
      } catch (error: any) {
        error.message;
      }
    };
    const interval = setInterval(fetchData, 5000);
    return () => clearInterval(interval);
  }, [navigate, sessionMail]);

  return (
    <>
      <img className="confirmationBackground" src={houseSvg} alt="Background" />
      <div className="confirmation">
        <h1 className="confirmation_h1">
          Vérifiez votre adresse email afin de finaliser votre inscription
        </h1>
        <div className="confirmation_line"></div>
        <h2 className="confirmation_h2">
          Merci d'avoir choisi <span>"Projet Immo"</span>
        </h2>
        <p className="confirmation_p">
          Veuillez confirmer votre adresse email en cliquant sur le bouton
          ci-dessous une fois que vous avez reçu le mail de confirmation.
        </p>
        {isConfirmed && (
          <p className="success_message">
            Inscription confirmée ! Redirection vers la connexion...
          </p>
        )}
      </div>
    </>
  );
}
