using Microsoft.AspNetCore.Mvc;
using CafeteriaMVC.Data;
using CafeteriaMVC.Models;

namespace CafeteriaMVC.Controllers
{
    public class HomeController : Controller
    {
        private readonly CafeteriaRepository _repo;

        public HomeController(CafeteriaRepository repo)
        {
            _repo = repo;
        }

        // 1. INICIO
        public IActionResult Index()
        {
            return View();
        }

        // 2. MENÚ PÚBLICO
        public IActionResult Menu()
        {
            var productos = _repo.ListarProductos();
            return View(productos);
        }

        // 3. RESERVAS PÚBLICAS
        [HttpGet]
        public IActionResult Reservas()
        {
            return View();
        }

        [HttpPost]
        public IActionResult Reservas(Reserva reserva)
        {
            _repo.CrearReserva(reserva);
            ViewBag.Mensaje = $"¡Tu mesa ha sido reservada con éxito para el {reserva.Fecha:dd/MM/yyyy} a las {reserva.Hora}!";
            return View();
        }

        // 4. CONTACTO PÚBLICO
        [HttpGet]
        public IActionResult Contacto()
        {
            return View();
        }

        [HttpPost]
        public IActionResult Contacto(Mensaje mensaje)
        {
            _repo.CrearMensaje(mensaje);
            ViewBag.Mensaje = "Gracias por escribirnos. Tu mensaje ya fue registrado en MySQL.";
            return View();
        }

        // 5. ESTADÍSTICAS SQL (COUNT, AVG, MAX, MIN, SUM, GROUP BY)
        public IActionResult Estadisticas()
        {
            var stats = _repo.ObtenerEstadisticas();
            return View(stats);
        }

        // 6. PANEL ADMIN (CRUD COMPLETO PARA LAS 3 TABLAS)
        public IActionResult Admin(int? editarProd, int? editarRes, int? editarMsg)
        {
            var productos = _repo.ListarProductos();
            var reservas = _repo.ListarReservas();
            var mensajes = _repo.ListarMensajes();

            ViewBag.Productos = productos;
            ViewBag.Reservas = reservas;
            ViewBag.Mensajes = mensajes;

            ViewBag.ProdEditar = editarProd.HasValue ? productos.FirstOrDefault(p => p.Id == editarProd.Value) : null;
            ViewBag.ResEditar  = editarRes.HasValue  ? reservas.FirstOrDefault(r => r.Id == editarRes.Value)   : null;
            ViewBag.MsgEditar  = editarMsg.HasValue  ? mensajes.FirstOrDefault(m => m.Id == editarMsg.Value)   : null;

            return View();
        }

        // --- ACCIONES PRODUCTOS ---
        [HttpPost]
        public IActionResult GuardarProducto(Producto p)
        {
            if (p.Id == 0) _repo.CrearProducto(p);
            else _repo.EditarProducto(p);
            TempData["Alerta"] = "Producto guardado correctamente.";
            return RedirectToAction("Admin");
        }

        public IActionResult BorrarProducto(int id)
        {
            _repo.BorrarProducto(id);
            TempData["Alerta"] = "Producto eliminado.";
            return RedirectToAction("Admin");
        }

        // --- ACCIONES RESERVAS ---
        [HttpPost]
        public IActionResult GuardarReserva(Reserva r)
        {
            if (r.Id == 0) _repo.CrearReserva(r);
            else _repo.EditarReserva(r);
            TempData["Alerta"] = "Reserva actualizada correctamente.";
            return RedirectToAction("Admin");
        }

        public IActionResult BorrarReserva(int id)
        {
            _repo.BorrarReserva(id);
            TempData["Alerta"] = "Reserva eliminada.";
            return RedirectToAction("Admin");
        }

        // --- ACCIONES MENSAJES ---
        [HttpPost]
        public IActionResult GuardarMensaje(Mensaje m)
        {
            if (m.Id == 0) _repo.CrearMensaje(m);
            else _repo.EditarMensaje(m);
            TempData["Alerta"] = "Mensaje actualizado correctamente.";
            return RedirectToAction("Admin");
        }

        public IActionResult BorrarMensaje(int id)
        {
            _repo.BorrarMensaje(id);
            TempData["Alerta"] = "Mensaje eliminado.";
            return RedirectToAction("Admin");
        }
    }
}