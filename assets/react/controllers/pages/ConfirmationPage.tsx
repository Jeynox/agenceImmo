import React from 'react';
import '../style/confirmation.scss'

export default function ConfirmationPage() {
    return (
        <>
            <div className='confirmation'>
                <h1 className='confirmation_h1'>Vérifiez votre adresse email afin de finaliser votre inscription</h1>
                <div className='confirmation_line'></div>
                <h2 className='confirmation_h2'>Merci d'avoir choisi <span>"Projet Immo"</span></h2>
                <p className='confirmation_p'>Veuillez confirmer votre adresse email en cliquant sur le mail qui vous a été envoyé</p>
            </div>
        </>
    )
}