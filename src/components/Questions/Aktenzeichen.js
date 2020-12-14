import React from "react";
import { Controller } from "react-hook-form";
import MaskedInput from "antd-mask-input";
import errorMessages from "../../utils/errorMessages";
import customValidations from "../../utils/customValidation";

const Aktenzeichen = ({control, errors, value}) => (
  <div className="question">
    <label className="required" htmlFor="Aktenzeichen">
      Aktenzeichen
    </label>
    <Controller
      as={
        <MaskedInput
          className={
            errors &&
            errors.Aktenzeichen &&
            "input-error"
          }
          placeholder="Aktenzeichen"
          size={9}
          mask="111111-11"
        />
      }
      defaultValue={value && decodeURI(value)}
      control={control}
      name="Aktenzeichen"
      id="Aktenzeichen"
      rules={{
        required: errorMessages.required,
        validate: {
          inputAktenzeichenCorrect: customValidations.isIncorrectAktenzeichen
        }
      }}
    />
    {errors && errors.Aktenzeichen && (
      <span className="message-error">
        {errors.Aktenzeichen.message}
      </span>
    )}
  </div>
);

export default Aktenzeichen