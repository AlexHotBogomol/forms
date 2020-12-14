import React from "react";
import { Controller } from "react-hook-form";
import rechtsschutzersicherung from "../../data/rechtsschutzersicherung";
import {
  Select,
} from "antd";

const {Option} = Select;

const Question9 = ({control, value}) => {

  const getValue = (value) => {
    let result = value.replace(/\+/g, '%20');
    return decodeURIComponent(result)
  };

  return (
    (
      <div className="question">
        <label htmlFor="Clientdata.Rechtsschutzersicherung">
          9. Rechtsschutzersicherung
        </label>
        <Controller
          as={
            <Select
              placeholder="RechtsschutzersicherungName"
              style={{ width: "100%" }}
              showSearch={true}
              optionFilterProp="children"
              size="large"
              filterOption={(input, option) =>
                option.children.toLowerCase().indexOf(input.toLowerCase()) === 0
              }
            >
              {rechtsschutzersicherung.map((option, index)=>(
                <Option key={index} value={JSON.stringify(option)}>{option.title}</Option>
              ))}
            </Select>
          }
          defaultValue={value && getValue(value)}
          control={control}
          name="Clientdata.Rechtsschutzersicherung"
          id="Clientdata.Rechtsschutzersicherung"
        />
      </div>
    )
  )
};

export default Question9