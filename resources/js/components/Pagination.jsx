import React from "react";
import { Link } from "@inertiajs/react";

const Pagination = ({ links = [] }) => {
    if (links.length <= 3) return null;

    return (
        <div className="flex justify-between items-center">
            <div className="flex mx-auto items-center gap-3 mt-6 flex-wrap">
                {links.map((link, index) => (
                    <Link
                        href={link.url || "#"}
                        key={index}
                        className={`px-3 py-2 text-sm rounded transition ${
                            link.active
                                ? "bg-blue-600 text-white"
                                : !link.url
                                ? "bg-gray-100 text-gray-400 cursor-not-allowed"
                                : "bg-gray-200 text-gray-800 hover:bg-gray-300"
                        }`}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                        preserveScroll
                    />
                ))}
            </div>
        </div>
    );
};

export default Pagination;
