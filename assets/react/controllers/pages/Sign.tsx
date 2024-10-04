import React from 'react';
import { useState } from 'react';
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faArrowRight, faEye, faEyeSlash } from "@fortawesome/free-solid-svg-icons";
import { IconDefinition } from '@fortawesome/fontawesome-common-types';
import { useNavigate } from 'react-router-dom';


export default function Sign() {
    const [email, setEmail] = useState<string>("");
    const [password, setPassword] = useState<string>("");
    const [type, setType] = useState<string>("password");
    const [eye, setEye] = useState<IconDefinition>(faEyeSlash);
    const [erreur, setErreur] = useState<string | null>(null)
    const [errorMessages, setErrorMessages] = useState<string[]>([]);
    const nav = useNavigate();

    const handleShowPassword = () => {
        if (type === "password") {
            setType("text");
            setEye(faEye);
        } else {
            setType("password");
            setEye(faEyeSlash); 
        }
    }

    const handleSignUp = (e:any) => {
        e.preventDefault();
        /* Fetch pour envoyer une requette http au serveur via une methode POST sur l'URL /api/sign */
        fetch('/api/sign', {
            method: 'POST',

            /* L'entete sert a envoyer les données au format  JSON */
            headers: {
                'Content-Type': 'application/json'
            },

            /* Le corps de la requête contient les données de l'utilisateur, à savoir l'email et le mot de passe, converties en JSON à l'aide de JSON.stringify */
            body: JSON.stringify({email, password})
        })
        .then((res) => {
          /* On reçoi les données du back de si l'adresse mail existe deja en bdd */
          if (!res.ok) {
            return res.json().then((data) => {

              /* On affiche un message d'erreur si l'adresse mail existe deja en bdd */
              throw new Error(data.error || 'Cet email est déjà utilisé');
            });
          }
          return res.json();
        })
        .then((data) => {
            console.log(data);
        })
        .catch((err) => {
            console.error(err);
            /* On set le message d'erreur */
            setErrorMessages([err.message]);
        })
        /**  
        * TODO: Rediriger l'utilisateur vers la page d'attente de validation par mail
          nav('/#');
        */
    }

    return (
        <>
      <div className="page_login">
        <div className="login">
          <h1 className="login_title">Inscription</h1>

          {/* On affiche les messages d'erreur */}
          <p className="login_p">{errorMessages}</p>
          <form method="post" onSubmit={handleSignUp} className="login_form">
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

            {/**
             * TODO Ajouter un verificateur de champ de mot de passe
             */}
             
            <p className="login_form_p">
              Vous avez déjà un compte ? <a href="/login">Se connecter</a>
            </p>
            <p className="login_form_p_CGU">
              En cliquant sur s'inscrire, vous acceptez nos 
              <a href="#"> Conditions Générales d'utilisation </a>
              ainsi que notre 
              <a href="#"> Politique de confidentialité</a>
            </p>
            <button type="submit" className="login_form_button"><span>Connexion</span> <FontAwesomeIcon className="login_form_button_icon" icon={faArrowRight} /></button>
          </form>
        </div>
        <div className="login_image">
          <img
            src=""
            alt="image"
          />
        </div>
      </div>
    </>
    )
}