import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import '../style/login.scss';

export default function Login() {
    const [email, setEmail] = useState<string>("");
    const [password, setPassword] = useState<string>("");
    const navigate = useNavigate(); 

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
        } else {
            console.log("Erreur de connexion");
        }
    };

    return (
        <>
        <div className="login">
            <h1>Connexion</h1>
            <form onSubmit={handleSubmit} className="login_form">
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
                <input
                    type="password"
                    id="password"
                    name="_password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                />
                </div>
                <button type="submit">Connexion</button>
            </form>
            </div>
        </>
    );
}
