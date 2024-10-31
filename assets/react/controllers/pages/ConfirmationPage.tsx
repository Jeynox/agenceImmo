import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import '../style/confirmation.scss';
import houseSvg from '../images/svg/house.svg';

export default function ConfirmationPage() {
    const [isConfirmed, setIsConfirmed] = useState(false);
    const [errorMessage, setErrorMessage] = useState('');
    const navigate = useNavigate(); // Hook pour redirection

    useEffect(() => {
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token'); // Assurez-vous que le token est passé comme paramètre dans l'URL

        const confirmEmail = async () => {
            try {
                const response = await fetch(`http://127.0.0.1:8000/confirmation/${token}`, {
                    method: 'GET',
                });

                if (response.ok) {
                    setIsConfirmed(true);
                    setTimeout(() => {
                        navigate('/login'); // Rediriger vers la page de connexion après 3 secondes
                    }, 3000); // Attendre 3 secondes avant de rediriger
                } else {
                    const data = await response.json();
                    setErrorMessage(data.message || 'Erreur lors de la confirmation.');
                }
            } catch (error) {
                console.error('Erreur:', error);
                setErrorMessage('Erreur lors de la confirmation.');
            }
        };

        if (token) {
            confirmEmail();
        }
    }, [navigate]); // Dépendance à la redirection
    return (
        <>
            <img className='confirmationBackground' src={houseSvg} alt="" />
            <div className='confirmation'>
                <h1 className='confirmation_h1'>Vérifiez votre adresse email afin de finaliser votre inscription</h1>
                <div className='confirmation_line'></div>
                <h2 className='confirmation_h2'>Merci d'avoir choisi <span>"Projet Immo"</span></h2>
                <p className='confirmation_p'>
                        Veuillez confirmer votre adresse email en cliquant sur le mail qui vous a été envoyé .
                </p>
            </div>
        </>
    )
}