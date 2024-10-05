import React from 'react';
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./pages/Login";
import Home from './pages/Home'
import ConfirmationPage from './pages/ConfirmationPage'

export default function Main() {

    return (
        <Router>
        <Routes>
        <Route  path="/" element={<Home />} />
        <Route path='/login' element={<Login />}/>
        <Route path="/confirmation" element={<ConfirmationPage />} />
        </Routes>
    </Router>
);
}
