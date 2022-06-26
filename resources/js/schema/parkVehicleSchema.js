import * as yup from 'yup'

export const parkVehicleSchema = yup.object().shape({
  plate_number: yup.string()
      .nullable()
      .required()
      .label('Plate Number'),
  vehicle_type: yup.string()
      .nullable()
      .required()
      .label('Vehicle Type'),
  entry_point: yup.string()
      .nullable()
      .required()
      .label('Entry Point'),
  time_in: yup.string()
      .nullable()
      .required()
      .label('Time in'),

});