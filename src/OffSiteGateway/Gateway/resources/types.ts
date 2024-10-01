import {FC} from 'react';

export interface GatewaySettings {
    label: string;
}

export interface RegisteredGateway {
    /**
     * The gateway ID. Must be the same as the back-end
     */
    id: string;

    /**
     * The gateway label
     */
    label?: string;

    /**
     * Settings for the gateway as sent from the back-end
     */
    settings?: GatewaySettings;

    /**
     * Whether the gateway supports recurring donations
     */
    supportsSubscriptions?: boolean;
}

export interface Gateway extends RegisteredGateway {
    /**
     * Initialize function for the gateway. The settings are passed to the gateway
     * from the server. This is called once before the form is rendered.
     */
    initialize?(): void;

    /**
     * The component to render when the gateway is selected
     */
    Fields: FC;

    /**
     * A hook before the form is submitted.
     */
    beforeCreatePayment?(values: FormData): Promise<object> | Error;

    /**
     * A hook after the form is submitted.
     */
    afterCreatePayment?(response: FormResponse): Promise<void> | Error;
}

interface FormResponse {
    type: string;
    data: any;
}

declare global {
    interface Window {
        givewp: {
            gateways: {
                register: (gateway: Gateway) => void;
            };
        };
    }
}
