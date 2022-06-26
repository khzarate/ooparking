import API from '../services/Index'

const PARKING_ENDPOINT = '/api';


export default {
  parkVehicle: (payload) => API.post(`${PARKING_ENDPOINT}/park-vehicle`, payload),
  unparkVehicle: (payload) => API.post(`${PARKING_ENDPOINT}/unpark-vehicle`, payload),
  getParkingSlotCount: () => API.get(`${PARKING_ENDPOINT}/slot-count`)
}