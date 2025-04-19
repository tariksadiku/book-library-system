import { Link } from "@inertiajs/react";

export default function Layout({ children }) {
    return (
        <>
            <header className="bg-white shadow-md">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                    <h1 className="text-xl font-bold text-blue-600">
                        Book library
                    </h1>
                    <nav className="space-x-4">
                        <Link
                            href="/authors"
                            className="text-gray-700 hover:text-blue-600 transition-colors"
                        >
                            Authors
                        </Link>
                        <Link
                            href="/books"
                            className="text-gray-700 hover:text-blue-600 transition-colors"
                        >
                            Books
                        </Link>
                    </nav>
                </div>
            </header>

            <main className="min-h-screen bg-gray-100 text-gray-900 justify-center items-center">
                <article className="flex w-full justify-center p-4">
                    {children}
                </article>
            </main>
        </>
    );
}
