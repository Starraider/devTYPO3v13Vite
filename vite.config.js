import { defineConfig } from "vite";
import typo3 from "vite-plugin-typo3";
import liveReload from 'vite-plugin-live-reload'

export default defineConfig({
    plugins: [typo3(), liveReload('packages/**/*.php', 'packages/**/*.html')],
    build: {
        rollupOptions: {
            output: {
                // Verhindert das Umbenennen von Variablen, die zu Konflikten führen können
                generatedCode: {
                    preset: 'es2015',
                    symbols: true
                }
            }
        },
        // Verwende terser statt esbuild für die Minifizierung
        minify: 'terser',
        target: 'es2015',
        terserOptions: {
            compress: {
                // Verhindert das Umbenennen von Variablen, die globale Eigenschaften überschatten könnten
                keep_fnames: true,
                // Deaktiviert aggressive Optimierungen
                drop_console: false,
                drop_debugger: false
            },
            mangle: {
                // Verhindert das Umbenennen von Funktionsnamen
                keep_fnames: true,
                // Verhindert das Umbenennen von Klassennamen
                keep_classnames: true
            }
        }
    }
});
