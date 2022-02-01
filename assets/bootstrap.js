import { startStimulusApp } from '@symfony/stimulus-bridge';
import LiveController from '@symfony/ux-live-component';
// comment out above line and uncomment below to play with the live, Typescript code
// import LiveController from '../vendor/symfony/ux-live-component/assets/src/live_controller';
import '@symfony/ux-live-component/styles/live.css';

// Registers Stimulus controllers from controllers.json and in the controllers/ directory
export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bridge/lazy-controller-loader!./controllers',
    true,
    /\.(j|t)sx?$/
));

// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);

app.register('live', LiveController);

