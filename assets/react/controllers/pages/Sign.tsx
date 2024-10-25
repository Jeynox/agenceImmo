import React from 'react';
import { useState } from 'react';
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faArrowRight, faEye, faEyeSlash } from "@fortawesome/free-solid-svg-icons";
import { IconDefinition } from '@fortawesome/fontawesome-common-types';
import { useNavigate } from 'react-router-dom';
import { toast } from 'react-toastify';
import design from "../images/design-interrieur.jpg";


export default function Sign() {
    const [email, setEmail] = useState<string>("");
    const [password, setPassword] = useState<string>("");
    const [type, setType] = useState<string>("password");
    const [eye, setEye] = useState<IconDefinition>(faEyeSlash);
    const [erreur, setErreur] = useState<string | null>(null)

    const [isUpperCase, setIsUpperCase] = useState<boolean>(false);
    const [hasNumber, setHasNumber] = useState<boolean>(false);
    const [hasSpecialChar, setHasSpecialChar] = useState<boolean>(false);
    const [isLongEnough, setIsLongEnough] = useState<boolean>(false);

    // Fonction qui permet de vérifier si le mot de passe respecte les conditions
    const checkPassword = (value: any) => {
      setPassword(value);
      setIsUpperCase(/[A-Z]/.test(value));
      setHasNumber(/[0-9]/.test(value));
      setHasSpecialChar(/[^A-Za-z0-9]/.test(value));
      setIsLongEnough(value.length >= 12);      
    }

    // On vérifie si toutes les conditions sont respectées
    const allConditions = isUpperCase && hasNumber && hasSpecialChar && isLongEnough;

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

    const handleSignUp = (e: React.FormEvent) => {
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
            setTimeout((async:any) => {
                if (res.ok) {
                  toast.success("Veuillez verifier votre boite mail pour valider votre inscription",{
                    autoClose: 5000
                  })
                  /**  
                    * TODO: Rediriger l'utilisateur vers la page d'attente de validation par mail
                  */
                    nav('/login');
                } else {
                    toast.error("Erreur lors de l'inscription", {
                      autoClose: 5000
                    });
                    setErreur("Erreur lors de l'inscription");
                }
            }, 1000)
          return res.json();
        })
        
    }

    return (
        <>
      <div className="page_login">
        <div className="login">
          <h1 className="login_title">Inscription</h1>

          {/* On affiche les messages d'erreur */}
          <p className="login_p">{erreur}</p>
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
                  onChange={(e) => checkPassword(e.target.value)}
                />
                <span className="login_form_mdp_container_icon" onClick={handleShowPassword}>
                  <FontAwesomeIcon icon={eye} />
                </span>
              </div>
            </div>
            <div className='login_form_list'>
              <ul className='login_form_list_ul'>
                {/*On affiche les conditions à respecter pour le mot de passe*/}
                <li style={{color: isLongEnough ? '#017E5B' : '#D91414'}}>X 12 caractères minimum</li>
                <li style={{color: hasSpecialChar ? '#017E5B' : '#D91414'}}>X 1 caractère spécial</li>
              </ul>
              <ul className='login_form_list_ul'>
                <li style={{color: isUpperCase ? '#017E5B' : '#D91414'}}>X 1 majuscule</li>
                <li style={{color: hasNumber ? '#017E5B' : '#D91414'}}>X 1 chiffre</li>
              </ul>
            </div>

            <p className="login_form_p">
              Vous avez déjà un compte ? <a href="/login">Se connecter</a>
            </p>
            <p className="login_form_p_CGU">
              En cliquant sur s'inscrire, vous acceptez nos 
              <a href="#"> Conditions Générales d'utilisation </a>
              ainsi que notre 
              <a href="#"> Politique de confidentialité</a>
            </p>
            {/* On désactive le bouton d'inscription si toutes les conditions ne sont pas respectées */}
            <button type="submit" disabled={!allConditions} className="login_form_button"><span>Inscription</span> <FontAwesomeIcon className="login_form_button_icon" icon={faArrowRight} /></button>
          </form>
        </div>
        <div className="login_image">
          <img className='img_login'
            src={design}
            alt="image"
          />
        </div>
      </div>
    </>
    )
}