import {GiveAddonSettingsProps} from './GiveAddonSettingsProps';

export type customSettingsProps = {
    addonSettings: GiveAddonSettingsProps;
    updateAddonSettings: (property: string, value: any) => void;
};
