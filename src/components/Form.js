import React, { useState, useEffect } from "react";
import {useForm} from "react-hook-form";
import {useLocation} from "react-router-dom";
import Question1 from "./Questions/Question1";
import {Col, Row} from "antd";
import axios from "axios";
import { v1 as uuidv1 } from "uuid";
import disableScroll from "disable-scroll";
import Modal from "./Modal";
import Question2 from "./Questions/Question2";
import Question3 from "./Questions/Question3";
import Question4 from "./Questions/Question4";
import Question5 from "./Questions/Question5";
import Question6 from "./Questions/Question6";
import Question7 from "./Questions/Question7";
import Question8 from "./Questions/Question8";
import Question9 from "./Questions/Question9";
import Question10 from "./Questions/Question10";
import Aktenzeichen from "./Questions/Aktenzeichen";

const id = uuidv1();
const CONTACT_API_PATH = "/api/contact/mailer.php";
const POSTCODES_API_PATH = "https://api.zippopotam.us/de/";


function useQuery() {
  return new URLSearchParams(useLocation().search);
}

const Form = () => {
  let query = useQuery();

  const {
    handleSubmit,
    control,
    errors,
    setValue,
    register
  } = useForm();

  const onSubmit = (data, e) => {
    console.log(data);
    e.preventDefault();
    axios({
      method: "post",
      url: `${CONTACT_API_PATH}`,
      headers: { "content-type": "application/json" },
      data: data
    })
      .then(response => {
        onOpenModal();
      })
      .catch(function(error) {
        console.log(error);
      });
  };

  useEffect(() => {
    const firstErrorInput = document.querySelector(".input-error");
    if (firstErrorInput && firstErrorInput.classList.contains("ant-input")) {
      firstErrorInput.focus();
    } else if (
      firstErrorInput &&
      !firstErrorInput.classList.contains("ant-input")
    ) {
      firstErrorInput.querySelector("input").focus();
    }
  }, [errors]);


  const [isModalOpen, setIsModalOpen] = useState(false);

  const onCloseModal = event => {
    setIsModalOpen(false);
    document.location.href = "https://www.brs-ag.de/";
  };

  const onOpenModal = event => {
    setIsModalOpen(true);
  };

  const clearNumericMaskInput = value => {
    return value.replace(/[^0-9]/g, "");
  };

  const onPlzChange = (event, cityField) => {
    const plz = clearNumericMaskInput(event.target.value);
    if (plz.length === 5) {
      axios({
        method: "get",
        url: `${POSTCODES_API_PATH}${plz}`
      }).then(
        function({ data }) {
          const city = data.places[0]["place name"];
          if (city) {
            setValue(cityField, city);
          }
        },
        function(err) {
          console.log(err);
        }
      );
    }
    return event.target.value;
  };

  useEffect(() => {
    if (isModalOpen && window.innerWidth >= 1200) {
      disableScroll.on();
    } else if (isModalOpen && window.innerWidth < 1200) {
      document.body.style.overflow = "hidden";
    } else {
      disableScroll.off();
      document.body.style.overflow = "unset";
    }
  }, [isModalOpen]);

  return (
    <>
      <form onSubmit={handleSubmit(onSubmit)}>
        <Row gutter={30}>
          <Col sm={{span: 16}}>
            <Question1 control={control} value={query.get("geschlecht")}/>
          </Col>
        </Row>
        <Row gutter={30}>
          <Col xs={{ span: 24 }} sm={{ span: 12 }}>
            <Question2
              control={control}
              errors={errors}
              value={query.get("vorname")}
            />
          </Col>
          <Col xs={{ span: 24 }} sm={{ span: 12 }}>
            <Question3 control={control} errors={errors} value={query.get("nachname")}/>
          </Col>
        </Row>
        <Question4 control={control} errors={errors} value={query.get("telefon")}/>
        <Question5 control={control} errors={errors} value={query.get("email")}/>
        <Question6 control={control} errors={errors} value={query.get("strase")}/>
        <Row gutter={30}>
          <Col xs={{ span: 24 }} sm={{ span: 12 }}>
            <Question7
              control={control}
              errors={errors}
              onPlzChange={onPlzChange}
              value={query.get("plz")}
            />
          </Col>
          <Col xs={{ span: 24 }} sm={{ span: 12 }}>
            <Question8 control={control} errors={errors} value={query.get("stadt")}/>
          </Col>
        </Row>
        <Question9 control={control} value={query.get("rechtsschutzersicherung")}/>
        <Question10 control={control} value={query.get("schadennummer")}/>
        <input type="hidden" value={id} name="id" ref={register} />
        <button className="btn" type="submit">
          Daten senden
        </button>
        <p className="message-info message-success">
          <span>
            Bitte überprüfen Sie Ihre Eingaben vor dem Absenden auf Richtigkeit!
          </span>
        </p>
      </form>
      <Modal isOpen={isModalOpen} onClose={onCloseModal} bgColor="#ffffff">
        <div className="modal-content">
          <div className="modal-icon">
            <svg
              className="checkMark"
              width="56"
              height="56"
              viewBox="0 0 56 56"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                className="checkMark-bg"
                d="M53.76 0H2.24C1.001 0 0 1.001 0 2.24V53.76C0 54.999 1.001 56 2.24 56H53.76C54.999 56 56 54.999 56 53.76V2.24C56 1.001 54.999 0 53.76 0Z"
                fill="#FFCC00"
              />
              <path
                className="checkMark-item"
                d="M16 25.5L24.5 36.5L38.5 17.5"
                stroke="none"
              />
            </svg>
          </div>
          <h1 className="modal-title">
            Vielen Dank für Ihre Angaben und die Übersendung der
            Verfahrensunterlagen!
          </h1>
          <div className="modal-description">
            <p>
              Wir werden uns nunmehr für Sie legitimieren und Akteneinsicht
              beantragen.
            </p>
            <p>Nach Erhalt der Akte kommen wir auf den Vorgang zurück.</p>
            <p>
              Sollten Sie zum Verfahren weitere Unterlagen erhalten, so reichen
              Sie uns diese bitte stets unaufgefordert und unter Angabe des
              Aktenzeichens ein.
            </p>
          </div>
          <div className="modal-btnWrapper">
            <button className="btn" onClick={onCloseModal}>
              Abschließen
            </button>
          </div>
        </div>
      </Modal>
    </>
  );
};

export default Form;
