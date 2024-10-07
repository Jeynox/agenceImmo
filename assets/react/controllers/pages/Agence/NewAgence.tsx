import React, { useState } from "react";
import { useNavigate } from "react-router-dom";

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
  const [errors, setErrors] = useState<{[error : string] : string}>({})
  function handleChange(e : any) {
    const {name, value } = e.target;
    setNewAgence((prevState) => ({
        ...prevState,
        [name] : value
    }));
  }

  const handleSubmit = async( e : any) => {
    e.preventDefault();
  const response = await fetch('/api/agence/new', {
        method: 'POST', 
        headers : {
            "Content-Type": "application/json",
        }, 
        body : JSON.stringify(newAgence)
    })
    const data = await response.json();
    if (response.ok) {
        nav("/");
        window.location.reload();
      } else {
        console.log("Erreur de connexion");
        setErrors(data.errors)
      }
  }
  console.log(errors);

  return (
    <>
      <form method="post" onSubmit={handleSubmit}>
        <div>
        {errors &&
            Object.keys(errors).map((error, index) => (
              <p key={index}>{errors[error]}</p>
            ))}
          <label htmlFor="email">Email :</label>
          <input type="email" id="email" name="email" required onChange={handleChange}/>
        </div>

        <div>
          <label htmlFor="name">Nom de l'agence :</label>
          <input type="text" id="name" name="name" required onChange={handleChange}/>
        </div>

        <div>
          <label htmlFor="address">Adresse :</label>
          <input type="text" id="address" name="address" required onChange={handleChange}/>
        </div>

        <div>
          <label htmlFor="postalCode">Code postal :</label>
          <input type="text" id="postalCode" name="postalCode" required onChange={handleChange}/>
        </div>

        <div>
          <label htmlFor="city">Ville :</label>
          <input type="text" id="city" name="city" required onChange={handleChange}/>
        </div>

        <div>
          <label htmlFor="website">Site web :</label>
          <input type="text" id="website" name="website" required onChange={handleChange}/>
        </div>

        <button type="submit">Enregistrer l'agence</button>
      </form>
    </>
  );
}
