import * as yup from 'yup'

export const unparkVehicleSchema = yup.object().shape({
  plate_number: yup.string()
      .nullable()
      .required()
      .label('Plate Number'),
  exit_point: yup.string()
      .nullable()
      .required()
      .label('Exit Point'),
  time_out: yup.string()
      .nullable()
      .required()
      .label('Time Out'),

});