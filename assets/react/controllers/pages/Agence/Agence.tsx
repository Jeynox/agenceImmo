import React, { useEffect, useState } from "react";
import "../../style/global/loading.scss";

interface Agence {
  id: string;
  name: string;
  email: string;
  website: string;
  city: string;
  address: string;
  codePostal: string;
}

export default function Agence() {
  const [agences, setAgences] = useState<Agence[]>([]);
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState<boolean>(true);
  const token = localStorage.getItem("token");

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch("api/agence", {
          method: "GET",
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json",
          },
        });

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.error);
        }

        const data = await response.json();
        setAgences(data);
      } catch (error: any) {
        setError(error.message);
      } finally {
        setTimeout(() => {
          setLoading(false);
        }, 3000);
      }
    };
    fetchData();
  }, []);

  if (loading) {
    return (
      <>
        <div className="container-loader">
          <div className="loader"></div>
        </div>
      </>
    );
  }

  if (error) {
    return <p>Erreur : {error}</p>;
  }

  return (
    <>
      <h1>Mes agences</h1>
      <a href="/agence/ajouter"> Ajouter une agence</a>
      {agences.length === 0 ? (
        <p>Aucune agence trouvée</p>
      ) : (
        <ul>
          {agences.map((agence: Agence) => (
            <li key={agence.id}>{agence.name}</li>
          ))}
        </ul>
      )}
    </>
  );
}
