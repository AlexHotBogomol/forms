import React from "react";
import { Controller } from "react-hook-form";
import errorMessages from "../../utils/errorMessages";
import {
  Input,
} from "antd";

const Question6 = ({control, errors, value}) => {
  const getValue = (value) => {
    let result = value.replace(/\+/g, '%20');
    return decodeURIComponent(result)
  };

  return (
    <div className="question">
      <label className="required" htmlFor="Clientdata.StrNr">
        6. Straße & Nr.
      </label>
      <Controller
        as={
          <Input
            className={
              errors &&
              errors.Clientdata &&
              errors.Clientdata.StrNr &&
              "input-error"
            }
            placeholder="Straße & Nr."
            size="large"
          />
        }
        defaultValue={value && getValue(value)}
        control={control}
        name="Clientdata.StrNr"
        id="Clientdata.StrNr"
        rules={{
          required: errorMessages.required,
          minLength: {
            value: 2,
            message: errorMessages.minLength("Strasse")
          }
        }}
      />
      {errors && errors.Clientdata && errors.Clientdata.StrNr && (
        <span className="message-error">
        {errors.Clientdata.StrNr.message}
      </span>
      )}
    </div>
  )
};

export default Question6