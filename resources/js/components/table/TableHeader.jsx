import React from "react";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faSort } from "@fortawesome/free-solid-svg-icons";

const TableHead = ({ columns, sortColumn, onSort }) => {
    return (
        <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                {columns.map((column) => (
                    <th
                        key={column.name}
                        scope="col"
                        className="px-6 py-3 cursor-pointer"
                        onClick={() => onSort(column.name)}
                    >
                        <div
                            className={`flex items-center gap-1 ${
                                sortColumn === column.name
                                    ? "text-blue-500"
                                    : ""
                            }`}
                        >
                            {column.label}
                            <FontAwesomeIcon icon={faSort} />
                        </div>
                    </th>
                ))}
                <th key="actions" scope="col" className="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
    );
};

export default TableHead;
