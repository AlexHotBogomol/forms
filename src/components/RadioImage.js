import React from "react";

const RadioImage = ({ name, id, value, title, onChangeRadioImage, checked, index, image}) => {
  return (
    <div className="radioImage">
      <input
        type="radio"
        name={name}
        id={id}
        className="radioImage-input"
        value={value}
        onChange={function (event) {
          onChangeRadioImage(event.target.value, index);
        }}
        checked={!!checked}
      />
      <label className="radioImage-label" htmlFor={id}>
        {image}
      </label>
      <p>{title}</p>
    </div>
  );
};

export default RadioImage;
