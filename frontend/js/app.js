const API_URL = "http://localhost/Sirob/backend/public";

// -----------------------------
// GENERIC HTTP REQUEST FUNCTION
// -----------------------------
async function apiRequest(endpoint, method = "GET", data = null) {
    const options = {
        method: method,
        headers: { "Content-Type": "application/json" }
    };

    if (data) options.body = JSON.stringify(data);

    const res = await fetch(`${API_URL}/${endpoint}`, options);
    return await res.json();
}

// -----------------------------
// CLIENTES
// -----------------------------
async function cargarClientes() {
    const data = await apiRequest("clientes");
    console.log("Clientes:", data);
    return data;
}

async function agregarCliente(cliente) {
    return await apiRequest("clientes", "POST", cliente);
}

async function actualizarCliente(id, cliente) {
    return await apiRequest(`clientes/${id}`, "PUT", cliente);
}

async function eliminarCliente(id) {
    return await apiRequest(`clientes/${id}`, "DELETE");
}

// -----------------------------
// VEHÍCULOS
// -----------------------------
async function cargarVehiculos() {
    return await apiRequest("vehiculos");
}

async function agregarVehiculo(v) {
    return await apiRequest("vehiculos", "POST", v);
}

async function actualizarVehiculo(id, v) {
    return await apiRequest(`vehiculos/${id}`, "PUT", v);
}

async function eliminarVehiculo(id) {
    return await apiRequest(`vehiculos/${id}`, "DELETE");
}

// -----------------------------
// EMPLEADOS
// -----------------------------
async function cargarEmpleados() {
    return await apiRequest("empleados");
}

async function agregarEmpleado(e) {
    return await apiRequest("empleados", "POST", e);
}

async function actualizarEmpleado(id, e) {
    return await apiRequest(`empleados/${id}`, "PUT", e);
}

async function eliminarEmpleado(id) {
    return await apiRequest(`empleados/${id}`, "DELETE");
}

// -----------------------------
// SERVICIOS
// -----------------------------
async function cargarServicios() {
    return await apiRequest("servicios");
}

async function agregarServicio(s) {
    return await apiRequest("servicios", "POST", s);
}

async function actualizarServicio(id, s) {
    return await apiRequest(`servicios/${id}`, "PUT", s);
}

async function eliminarServicio(id) {
    return await apiRequest(`servicios/${id}`, "DELETE");
}

// -----------------------------
// FACTURAS
// -----------------------------
async function cargarFacturas() {
    return await apiRequest("facturas");
}

async function crearFactura(data) {
    return await apiRequest("facturas", "POST", data);
}

async function actualizarFactura(id, data) {
    return await apiRequest(`facturas/${id}`, "PUT", data);
}

async function eliminarFactura(id) {
    return await apiRequest(`facturas/${id}`, "DELETE");
}

// ----------------------------------
// DESCARGAR FACTURA EN PDF (FPDF)
// ----------------------------------
function descargarFacturaPDF(idFactura) {
    window.open(`${API_URL}/facturas/pdf/${idFactura}`, "_blank");
}
