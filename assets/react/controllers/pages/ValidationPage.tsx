import React, { useEffect, useState } from 'react';
import '../style/confirmation.scss';
import houseSvg from '../images/svg/house.svg';
import { useParams } from 'react-router-dom';

export default function ValidationPage() {

    const [time, setTime] = useState<number>(20);

    let { token } = useParams();

    useEffect(() => {
        // Fonction pour effectuer la validation dès le chargement de la page
        const fetchData = async () => {
            try {
                const response = await fetch(`http://127.0.0.1:8000/api/validation/${token}`, {
                    method: 'GET'
                });
                
                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error);
                } else {
                    console.log("Validation réussie !");
                    // Si besoin, vous pouvez ajouter d'autres actions ici
                }
            } catch (error:any) {
                console.error("Erreur de validation:", error.message);
            }
        };
    
        // Appel immédiat pour valider
        fetchData();
    
        // Planifier la fermeture de la page après 20 secondes
        if (time > 0) {
            const timer = setTimeout(() => {
            setTime(time - 1)
            }, 1000);
            return () => clearTimeout(timer);
        } else {
            window.close();
        }
        
        // Nettoyer le timeout si le composant est démonté avant 20 secondes
    }, [time]);

    
    return (
        <>
            <img className='confirmationBackground' src={houseSvg} alt="Background" />
            <div className='confirmation'>
                <h1 className='confirmation_h1'>Votre adresse mail a bien été vérifiée</h1>
                <div className='confirmation_line'></div>
                <p className='confirmation_p'>Cette page va se fermer automatiquement au bout de {time} secondes pour un soucis d'écoconception</p>
            </div>
        </>
    );
}