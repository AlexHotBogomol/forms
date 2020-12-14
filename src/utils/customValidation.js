const clearNumericMaskInput = (value) => {
  return value.replace(/[^0-9]/g, "");
};

const clearAktenzeichenInput = (value) => {
  return value.replace(/[^0-9\-]/g, "");
};

const customValidations = {
  isIncorrectTel:  value => {
    if(!value) return;
    const clearedTel = clearNumericMaskInput(value);
    return clearedTel.length < 12 ? "Incorrect telephone format" : undefined;
  },
  isIncorrectPLZ: value => {
    if(!value) return;
    const clearedPLZ = clearNumericMaskInput(value);
    return clearedPLZ.length < 5 ? "Incorrect PLZ" : undefined;
  },
  isIncorrectAktenzeichen: value => {
    if(!value) return;
    const clearedAktenzeichen = clearAktenzeichenInput(value);
    return clearedAktenzeichen.length < 9 ? "Incorrect Aktenzeichen" : undefined;
  }
};

export default customValidations;