import OffSiteGatewayLogo from './OffSiteGatewayLogo';
import {Gateway} from './types';
import {__} from '@wordpress/i18n';

import './styles.scss';

const mollieGateway: Gateway = {
    id: 'ADDON_ID-off-site-gateway',
    Fields() {
        return (
            <div style={{textAlign: 'center'}}>
                <OffSiteGatewayLogo />
                <p>
                    {__(
                        'You will be redirected to an Off-Site Gateway simulation where will be possible to complete the payment and trigger webhook notifications for test purposes.',
                        'ADDON_TEXTDOMAIN'
                    )}
                </p>
            </div>
        );
    },
};

window.givewp.gateways.register(mollieGateway);
