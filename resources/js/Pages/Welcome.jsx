import React from 'react';
import { Link } from '@inertiajs/react';

export default function Welcome() {
    return (
        <div className="min-h-screen bg-gray-50">
            {/* Navigation */}
            <nav className="bg-white shadow-sm">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-16">
                        <div className="flex items-center">
                            <span className="text-2xl font-bold text-gray-900">TechNest</span>
                        </div>
                        <div className="flex items-center space-x-4">
                            <Link href="/login" className="text-gray-600 hover:text-gray-900">
                                Login
                            </Link>
                            <Link
                                href="/register"
                                className="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition"
                            >
                                Sign Up
                            </Link>
                        </div>
                    </div>
                </div>
            </nav>

            {/* Hero Section */}
            <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div className="text-center">
                    <h1 className="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                        <span className="block">Build Your Professional</span>
                        <span className="block text-indigo-600">Portfolio in Minutes</span>
                    </h1>
                    <p className="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Create stunning portfolios with our easy-to-use builder. Import your GitHub projects,
                        get AI-powered suggestions, and showcase your skills to the world.
                    </p>
                    <div className="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                        <div className="rounded-md shadow">
                            <Link
                                href="/register"
                                className="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10"
                            >
                                Build Your Portfolio Now
                            </Link>
                        </div>
                    </div>
                </div>

                {/* Feature Section */}
                <div className="mt-24 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div className="bg-white p-6 rounded-lg shadow-sm">
                        <div className="text-xl font-semibold mb-2">🚀 Quick Setup</div>
                        <p className="text-gray-600">Create your portfolio in minutes with our intuitive builder</p>
                    </div>
                    <div className="bg-white p-6 rounded-lg shadow-sm">
                        <div className="text-xl font-semibold mb-2">⚡ GitHub Integration</div>
                        <p className="text-gray-600">Import your projects directly from GitHub</p>
                    </div>
                    <div className="bg-white p-6 rounded-lg shadow-sm">
                        <div className="text-xl font-semibold mb-2">🤖 AI-Powered</div>
                        <p className="text-gray-600">Get smart suggestions to improve your portfolio</p>
                    </div>
                </div>
            </main>
        </div>
    );
} 