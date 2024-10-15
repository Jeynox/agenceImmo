import React, { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import "../../style/ad.scss";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {
  faUser,
  faAt,
  faPhone,
  faLocationDot,
  faArrowRight,
} from "@fortawesome/free-solid-svg-icons";
import Slider from "react-slick";

interface Ad {
  id: string;
  title: string;
  description: string;
  price: number;
  surface: number;
  city: string;
  address: string;
  postalCode: string;
  status: "Louer" | "Vendre";
  type: "Appartement" | "Maison";
  agence: {
    name: string;
    email: string;
    website: string;
    city: string;
    adress: string;
    postalCode: string;
    user: {
      email: string;
    };
  };
}

export default function Ad() {
  const [ad, setAd] = useState<Ad>();
  const { id } = useParams();

  useEffect(() => {
    const fetchData = async () => {
      const response = await fetch(`/api/ad/${id}`, {
        method: "GET",
      });
      const data = await response.json();
      setAd(data);
    };
    fetchData();
  }, [id]);
  const settings = {
    dots: true,
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
  };

  if (!ad) {
    return <p>Aucune annonce </p>;
  }
  return (
    <>
      <div className="page_ad">
        <div className="ad">
          <Slider >
            <div>
                <img src="https://picsum.photos/752/472" alt={ad.title} />
            </div>
            <div>
                <img src="https://picsum.photos/752/472" alt={ad.title} />
            </div>
            <div>
                <img src="https://picsum.photos/752/472" alt={ad.title} />
            </div>
            <div>
                <img src="https://picsum.photos/752/472" alt={ad.title} />
            </div>
          </Slider>
          <div className="ad_principal">
            <h1 className="ad_principal_title">{ad.title}</h1>
            <h2 className="ad_principal_title">{ad.price} €</h2>
          </div>
          <div className="ad_surface">
            <p>{ad.surface} m²</p>
          </div>
          <div className="ad_city">
            <h3>
              {ad.city} ({ad.postalCode})
            </h3>
          </div>
          <div className="ad_description">
            <p>{ad.description}</p>
          </div>
        </div>
        <div className="agency">
          <div className="agency_principal">
            <div className="agency_principal_title">
              <p>{ad.agence.name}</p>
              <p>
                {ad.agence.city} ({ad.agence.postalCode})
              </p>
            </div>
            <div className="agency_principal_img">
              <img src="https://picsum.photos/156/170" alt="test" />
            </div>
          </div>
          <div className="agency_contact">
            <FontAwesomeIcon icon={faUser} />
            <p>Jean Martin</p>
          </div>
          <div className="agency_contact">
            <FontAwesomeIcon icon={faAt} />
            <p>{ad.agence.user.email}</p>
          </div>
          <div className="agency_contact">
            <FontAwesomeIcon icon={faPhone} />
            <p>06.03.05.46.38</p>
          </div>
          <div className="agency_contact">
            <FontAwesomeIcon icon={faLocationDot} />
            <p>
              {ad.agence.adress}, {ad.agence.city}, {ad.agence.postalCode}
            </p>
          </div>
          <div className="agency_button">
            <button className="login_form_button">
              <span>Contacter</span>{" "}
              <FontAwesomeIcon
                className="login_form_button_icon"
                icon={faArrowRight}
              />
            </button>
          </div>
        </div>
      </div>
    </>
  );
}
