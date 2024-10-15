import React, { useEffect, useState } from "react"

interface Agence {
    id : string,
    name: string;
    email: string;
    website: string;
    city: string;
    address: string;
    codePostal: string;
}
  

export default function Agence() {
    const [agences, setAgences] = useState<Agence[]>([])
    const [error, setError] = useState<string | null>(null);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await fetch('/api/agence/', {
                    method: 'GET',
                    headers: {
                        "Content-Type": "application/json",
                    },
                });
    
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error);
                }
    
                const data = await response.json();
                setAgences(data);
            } catch (error : any) {
                setError(error.message);
            }
        };
        fetchData();
    }, []);

    if (error) { 
        return <p>Aucune agence trouvée</p>
    }
    return (
        <>
        <h1>Mes agences</h1>
<a href="/agence/ajouter"> Ajouter une agence</a>
        <ul>
            {agences.map((agence : Agence) => (
                
                <li key={agence.id}>{agence.name}</li>
            ))

            }
        </ul>
        
        </>
    )
}