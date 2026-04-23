export enum Type {
    Truck = 'truck',
    Trailer = 'trailer'
}

export interface TransportUnit {
	id: number;
	name: string;
	type: Type;
}