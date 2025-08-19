#!/usr/bin/env node

import { build } from 'esbuild';
import { execSync } from 'child_process';
import { readdirSync, existsSync } from 'fs';
import { join } from 'path';

const args = process.argv.slice(2);
const isDev = args.includes('--dev');
const isWatch = args.includes('--watch');

async function buildCSS() {
    const cssDir = join(process.cwd(), 'resources', 'css');
    const distDir = join(process.cwd(), 'resources', 'dist');
    
    if (!existsSync(cssDir)) {
        console.log('No CSS directory found, skipping CSS build');
        return;
    }

    try {
        const cssFiles = readdirSync(cssDir).filter(file => file.endsWith('.css'));
        
        for (const file of cssFiles) {
            const inputFile = join(cssDir, file);
            const outputFile = join(distDir, file);
            
            console.log(`Building CSS: ${file}`);
            
            // Use PostCSS to build CSS
            execSync(`npx postcss ${inputFile} -o ${outputFile}`, { stdio: 'inherit' });
        }
        
        console.log('CSS build completed successfully');
    } catch (error) {
        console.error('CSS build failed:', error);
        process.exit(1);
    }
}

async function buildJS() {
    const jsDir = join(process.cwd(), 'resources', 'js');
    const distDir = join(process.cwd(), 'resources', 'dist');
    
    if (!existsSync(jsDir)) {
        console.log('No JS directory found, skipping JS build');
        return;
    }

    try {
        const jsFiles = readdirSync(jsDir).filter(file => file.endsWith('.js'));
        
        for (const file of jsFiles) {
            const inputFile = join(jsDir, file);
            const outputFile = join(distDir, file.replace('.js', '.min.js'));
            
            console.log(`Building JS: ${file}`);
            
            await build({
                entryPoints: [inputFile],
                bundle: true,
                minify: !isDev,
                outfile: outputFile,
                format: 'esm',
                target: ['es2020'],
                watch: isWatch,
            });
        }
        
        console.log('JS build completed successfully');
    } catch (error) {
        console.error('JS build failed:', error);
        process.exit(1);
    }
}

async function main() {
    console.log('Building Filaforge Database Tools assets...');
    
    // Ensure dist directory exists
    const distDir = join(process.cwd(), 'resources', 'dist');
    if (!existsSync(distDir)) {
        execSync(`mkdir -p ${distDir}`, { stdio: 'inherit' });
    }
    
    try {
        await buildCSS();
        await buildJS();
        
        if (!isWatch) {
            console.log('Build completed successfully!');
        }
    } catch (error) {
        console.error('Build failed:', error);
        process.exit(1);
    }
}

main();
