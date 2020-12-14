import React from "react";
import { Controller } from "react-hook-form";
import errorMessages from "../../utils/errorMessages";
import {
  Input,
} from "antd";

const Question3 = ({control, errors, value}) => {
  const getValue = (value) => {
    let result = value.replace(/\+/g, '%20');
    return decodeURIComponent(result)
  };

  return (
    <div className="question">
      <label className="required" htmlFor="Clientdata.Nachname">
        3. Nachname
      </label>
      <Controller
        as={
          <Input
            className={
              errors &&
              errors.Clientdata &&
              errors.Clientdata.Nachname &&
              "input-error"
            }
            placeholder="Nachname"
            size="large"
          />
        }
        defaultValue={value && getValue(value)}
        control={control}
        name="Clientdata.Nachname"
        id="Clientdata.Nachname"
        rules={{
          required: errorMessages.required,
          minLength: {
            value: 2,
            message: errorMessages.minLength("Nachname")
          },
          pattern: {
            value: /^[A-Za-z \u00E4\u00F6\u00FC\u00C4\u00D6\u00DC\u00df]+$/i,
            message: errorMessages.specialChars()
          }
        }}
      />
      {errors && errors.Clientdata && errors.Clientdata.Nachname && (
        <span className="message-error">
          {errors.Clientdata.Nachname.message}
        </span>
      )}
    </div>
  )
};

export default Question3