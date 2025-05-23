import type { CapacitorConfig } from '@capacitor/cli'

const config: CapacitorConfig = {
  appId: 'com.bee.coffee.com',
  appName: 'Bee Coffee',
  webDir: 'dist',
  plugins: {
    StatusBar: {
      overlaysWebView: false,
      style: 'DARK',
    },
    SplashScreen: {
      launchShowDuration: 3000,
      launchAutoHide: true,
      launchFadeOutDuration: 3000,
      splashFullScreen: true,
      layoutName: 'launch_screen',
      splashImmersive: true,
      androidScaleType: "CENTER_CROP",
    },
  },
}

export default config
