import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "../style/login.scss";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faArrowRight, faEye, faEyeSlash } from "@fortawesome/free-solid-svg-icons";
import { IconDefinition } from '@fortawesome/fontawesome-common-types';


export default function Login() {
  const [email, setEmail] = useState<string>("");
  const [password, setPassword] = useState<string>("");
  let navigate = useNavigate();
  const [type, setType] = useState<string>("password");
  const [eye, setEye] = useState<IconDefinition>(faEyeSlash);
  const [erreur, setErreur] = useState<string | null>(null)

  const handleShowPassword = () => {
    if (type === "password") {
        setType("text");
        setEye(faEye);
    } else {
        setType("password");
        setEye(faEyeSlash); 
    }
  }

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    const response = await fetch("/api/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ username: email, password }),
      credentials: "same-origin",
    });
    if (response.ok) {
      navigate("/");
      window.location.reload();
    } else {
      console.log("Erreur de connexion");
      setErreur("Mot de passe ou Email non reconnu")
    }
  };

  return (
    <>
      <div className="page_login">
        <div className="login">
          <h1 className="login_title">Connexion</h1>
          <p className="login_p">{erreur}</p>
          <form method="post" onSubmit={handleSubmit} className="login_form">
            <div className="login_form_email">
              <label htmlFor="email">Email</label>
              <input
                type="email"
                id="email"
                name="_username"
                value={email}
                className="login_form_email_input"
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>
            <div className="login_form_mdp">
              <label htmlFor="password">Mot de passe</label>
              <div className="login_form_mdp_container">
              <input
                type={type}
                id="password"
                name="_password"
                value={password}
                className="login_form_mdp_container_input"
                onChange={(e) => setPassword(e.target.value)}
              />
              <span className="login_form_mdp_container_icon" onClick={handleShowPassword}>
                <FontAwesomeIcon icon={eye} />
              </span>
            </div>
            </div>
            <p className="login_form_p">
              Pas encore de compte ? <a href="#">Créer un compte</a>
            </p>
            <a className="login_form_a" href="#">Mot de passse oublié ?</a>
            <button type="submit" className="login_form_button"><span>Connexion</span> <FontAwesomeIcon className="login_form_button_icon" icon={faArrowRight} /></button>
          </form>
        </div>
        <div className="login_image">
          <img
            src="https://picsum.photos/800/1000"
            alt="image"
          />
        </div>
      </div>
    </>
  );
}
