import Pusher from "pusher-js";

declare global {
  interface Window {
    Pusher: typeof Pusher;
  }
}
declare global {
  interface Window {
    bootstrap: any;
  }
}

export {};
