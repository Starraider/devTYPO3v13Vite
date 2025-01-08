import { defineConfig } from "vite";
import typo3 from "vite-plugin-typo3";
import liveReload from 'vite-plugin-live-reload'

export default defineConfig({
    plugins: [typo3(), liveReload('packages/**/*.php', 'packages/**/*.html')],
});
