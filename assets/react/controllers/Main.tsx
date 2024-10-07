import React from 'react';
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./pages/Login";
import Home from './pages/Home'
import Sign from './pages/Sign';
import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import NewAgence from './pages/Agence/NewAgence';

export default function Main() {

    return (
        <>
            <Router>
                <Routes>
                    <Route  path="/" element={<Home />} />
                        <Route path='/login' element={<Login />}/>
                        <Route path='/sign' element={<Sign />}/>
                        <Route path='/agence/ajouter' element={<NewAgence />}/>
                </Routes>
            </Router>
            < ToastContainer
                position="top-right"
            />
        </>
    );
}
