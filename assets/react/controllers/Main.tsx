import React from 'react';
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./pages/Login";
import Home from './pages/Home'
import Sign from './pages/Sign';
import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import NewAgence from './pages/Agence/NewAgence';
<<<<<<< HEAD
import Ad from './pages/Annonce/Ad';
=======
import Agence from './pages/Agence/Agence';
>>>>>>> 4d02163c2c019ca319a5ba797793e52fd8f053a8

export default function Main() {

    return (
        <>
            <Router>
                <Routes>
                    <Route  path="/" element={<Home />} />
                        <Route path='/login' element={<Login />}/>
                        <Route path='/sign' element={<Sign />}/>
                        <Route path='/agence' element={<Agence />}/>
                        <Route path='/agence/ajouter' element={<NewAgence />}/>
                        <Route path='/annonce/:id' element={<Ad />}/>
                </Routes>
            </Router>
            < ToastContainer
                position="top-right"
            />
        </>
    );
}
