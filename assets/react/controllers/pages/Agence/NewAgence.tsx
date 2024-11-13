import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import "../../style/pages/agency.scss";
import { faArrowRight } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { IconDefinition } from "@fortawesome/fontawesome-common-types";

interface Agence {
  name: string;
  email: string;
  website: string;
  city: string;
  address: string;
  codePostal: string;
}

export default function NewAgence() {
  const [newAgence, setNewAgence] = useState<Agence>({
    name: "",
    email: "",
    website: "",
    city: "",
    address: "",
    codePostal: "",
  });
  const nav = useNavigate();
  const [errors, setErrors] = useState<{ [error: string]: string }>({});
  function handleChange(e: any) {
    const { name, value } = e.target;
    setNewAgence((prevState) => ({
      ...prevState,
      [name]: value,
    }));
  }

  const handleSubmit = async (e: any) => {
    e.preventDefault();
    const response = await fetch("/api/agence/new", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(newAgence),
    });
    const data = await response.json();
    if (response.ok) {
      nav("/");
      window.location.reload();
    } else {
      setErrors(data.errors);
    }
  };

  return (
    <>
      <div className="page_new_agency">
        <h1 className="page_new_agency_title"> Ajouter une nouvelle Agence</h1>
        <div className="error-messages">
        {errors && (
          <div className="error-message">
            {Object.keys(errors).map((error, index) => (
              <p key={index}>{errors[error]}</p>
            ))}
          </div>
        )}
          </div>
        <form method="post" onSubmit={handleSubmit} className="form_agency">
          <div className="form_agency_field">
            <label htmlFor="name">Nom de l'agence :</label>
            <input
              type="text"
              id="name"
              name="name"
             
              onChange={handleChange}
              className="form_agency_input"
            />
          </div>
          <div className="form_agency_field">
            <label htmlFor="email">Email :</label>
            <input
              type="email"
              id="email"
              name="email"
             
              onChange={handleChange}
              className="form_agency_input"
            />
          </div>

          <div className="form_agency_field">
            <label htmlFor="address">Adresse :</label>
            <input
              type="text"
              id="address"
              name="address"
              
              onChange={handleChange}
              className="form_agency_input"
            />
          </div>
          <div className="form_agency_group_input">
            <div className="form_agency_field form_agency_field_postal">
              <label htmlFor="postalCode">Code postal :</label>
              <input
                type="text"
                id="codePostal"
                name="postalCode"
            
                onChange={handleChange}
                className="form_agency_input"
              />
            </div>

            <div className="form_agency_field">
              <label htmlFor="city">Ville :</label>
              <input
                type="text"
                id="city"
                name="city"
           
                onChange={handleChange}
                className="form_agency_input"
              />
            </div>
          </div>
          <div className="form_agency_field">
            <label htmlFor="website">Site web :</label>
            <input
              type="text"
              id="website"
              name="website"
     
              onChange={handleChange}
              className="form_agency_input"
            />
          </div>

          <button type="submit" className="login_form_button">
            <span>Enregistrer l'agence</span>
            <FontAwesomeIcon
              className="login_form_button_icon"
              icon={faArrowRight}
            />
          </button>
        </form>
      </div>
    </>
  );
}
