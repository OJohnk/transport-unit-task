import axios from 'axios';
import { Type } from '../types/TransportUnit';

export function getUnits(type: Type, page: number = 1, search: string = '') {
    return axios.get('/api/transport-units', {
        params: { type, page, search: search || undefined }
    });
}

export function createUnit(name: string, type: Type) {
    return axios.post('/api/transport-units', { name, type });
}