using MySqlConnector;
using CafeteriaMVC.Models;

namespace CafeteriaMVC.Data
{
    public class CafeteriaRepository
    {
        private readonly string _connString;

        public CafeteriaRepository(IConfiguration config)
        {
            _connString = config.GetConnectionString("ConexionMySQL")!;
        }

        // ==================== 1. CRUD PRODUCTOS ====================
        public List<Producto> ListarProductos()
        {
            var lista = new List<Producto>();
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "SELECT id, nombre, descripcion, precio, categoria FROM productos ORDER BY categoria, nombre";
            using var cmd = new MySqlCommand(sql, conn);
            using var reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                lista.Add(new Producto
                {
                    Id = reader.GetInt32("id"),
                    Nombre = reader.GetString("nombre"),
                    Descripcion = reader.IsDBNull(2) ? "" : reader.GetString("descripcion"),
                    Precio = reader.GetDecimal("precio"),
                    Categoria = reader.GetString("categoria")
                });
            }
            return lista;
        }

        public void CrearProducto(Producto p)
        {
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "INSERT INTO productos (nombre, descripcion, precio, categoria) VALUES (@n, @d, @p, @c)";
            using var cmd = new MySqlCommand(sql, conn);
            cmd.Parameters.AddWithValue("@n", p.Nombre);
            cmd.Parameters.AddWithValue("@d", p.Descripcion);
            cmd.Parameters.AddWithValue("@p", p.Precio);
            cmd.Parameters.AddWithValue("@c", p.Categoria);
            cmd.ExecuteNonQuery();
        }

        public void EditarProducto(Producto p)
        {
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "UPDATE productos SET nombre=@n, descripcion=@d, precio=@p, categoria=@c WHERE id=@id";
            using var cmd = new MySqlCommand(sql, conn);
            cmd.Parameters.AddWithValue("@id", p.Id);
            cmd.Parameters.AddWithValue("@n", p.Nombre);
            cmd.Parameters.AddWithValue("@d", p.Descripcion);
            cmd.Parameters.AddWithValue("@p", p.Precio);
            cmd.Parameters.AddWithValue("@c", p.Categoria);
            cmd.ExecuteNonQuery();
        }

        public void BorrarProducto(int id)
        {
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "DELETE FROM productos WHERE id = @id";
            using var cmd = new MySqlCommand(sql, conn);
            cmd.Parameters.AddWithValue("@id", id);
            cmd.ExecuteNonQuery();
        }

        // ==================== 2. CRUD RESERVAS ====================
        public List<Reserva> ListarReservas()
        {
            var lista = new List<Reserva>();
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "SELECT id, nombre_cliente, correo, fecha, hora, personas FROM reservas ORDER BY fecha ASC, hora ASC";
            using var cmd = new MySqlCommand(sql, conn);
            using var reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                lista.Add(new Reserva
                {
                    Id = reader.GetInt32("id"),
                    NombreCliente = reader.GetString("nombre_cliente"),
                    Correo = reader.GetString("correo"),
                    Fecha = reader.GetDateTime("fecha"),
                    Hora = reader.GetValue(4).ToString()!,
                    Personas = reader.GetInt32("personas")
                });
            }
            return lista;
        }

        public void CrearReserva(Reserva r)
        {
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "INSERT INTO reservas (nombre_cliente, correo, fecha, hora, personas) VALUES (@n, @c, @f, @h, @p)";
            using var cmd = new MySqlCommand(sql, conn);
            cmd.Parameters.AddWithValue("@n", r.NombreCliente);
            cmd.Parameters.AddWithValue("@c", r.Correo);
            cmd.Parameters.AddWithValue("@f", r.Fecha.ToString("yyyy-MM-dd"));
            cmd.Parameters.AddWithValue("@h", r.Hora);
            cmd.Parameters.AddWithValue("@p", r.Personas);
            cmd.ExecuteNonQuery();
        }

        public void EditarReserva(Reserva r)
        {
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "UPDATE reservas SET nombre_cliente=@n, correo=@c, fecha=@f, hora=@h, personas=@p WHERE id=@id";
            using var cmd = new MySqlCommand(sql, conn);
            cmd.Parameters.AddWithValue("@id", r.Id);
            cmd.Parameters.AddWithValue("@n", r.NombreCliente);
            cmd.Parameters.AddWithValue("@c", r.Correo);
            cmd.Parameters.AddWithValue("@f", r.Fecha.ToString("yyyy-MM-dd"));
            cmd.Parameters.AddWithValue("@h", r.Hora);
            cmd.Parameters.AddWithValue("@p", r.Personas);
            cmd.ExecuteNonQuery();
        }

        public void BorrarReserva(int id)
        {
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "DELETE FROM reservas WHERE id = @id";
            using var cmd = new MySqlCommand(sql, conn);
            cmd.Parameters.AddWithValue("@id", id);
            cmd.ExecuteNonQuery();
        }

        // ==================== 3. CRUD MENSAJES ====================
        public List<Mensaje> ListarMensajes()
        {
            var lista = new List<Mensaje>();
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "SELECT id, nombre, correo, mensaje, fecha_envio FROM mensajes ORDER BY fecha_envio DESC";
            using var cmd = new MySqlCommand(sql, conn);
            using var reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                lista.Add(new Mensaje
                {
                    Id = reader.GetInt32("id"),
                    Nombre = reader.GetString("nombre"),
                    Correo = reader.GetString("correo"),
                    Texto = reader.GetString("mensaje"),
                    FechaEnvio = reader.GetDateTime("fecha_envio")
                });
            }
            return lista;
        }

        public void CrearMensaje(Mensaje m)
        {
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "INSERT INTO mensajes (nombre, correo, mensaje) VALUES (@n, @c, @m)";
            using var cmd = new MySqlCommand(sql, conn);
            cmd.Parameters.AddWithValue("@n", m.Nombre);
            cmd.Parameters.AddWithValue("@c", m.Correo);
            cmd.Parameters.AddWithValue("@m", m.Texto);
            cmd.ExecuteNonQuery();
        }

        public void EditarMensaje(Mensaje m)
        {
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "UPDATE mensajes SET nombre=@n, correo=@c, mensaje=@m WHERE id=@id";
            using var cmd = new MySqlCommand(sql, conn);
            cmd.Parameters.AddWithValue("@id", m.Id);
            cmd.Parameters.AddWithValue("@n", m.Nombre);
            cmd.Parameters.AddWithValue("@c", m.Correo);
            cmd.Parameters.AddWithValue("@m", m.Texto);
            cmd.ExecuteNonQuery();
        }

        public void BorrarMensaje(int id)
        {
            using var conn = new MySqlConnection(_connString);
            conn.Open();
            string sql = "DELETE FROM mensajes WHERE id = @id";
            using var cmd = new MySqlCommand(sql, conn);
            cmd.Parameters.AddWithValue("@id", id);
            cmd.ExecuteNonQuery();
        }

        // ==================== 4. ESTADÍSTICAS RAW SQL ====================
        public EstadisticasViewModel ObtenerEstadisticas()
        {
            var stats = new EstadisticasViewModel();
            using var conn = new MySqlConnection(_connString);
            conn.Open();

            // 1. COUNT
            stats.TotalProductos = Convert.ToInt32(new MySqlCommand("SELECT COUNT(*) FROM productos", conn).ExecuteScalar());
            stats.TotalReservas  = Convert.ToInt32(new MySqlCommand("SELECT COUNT(*) FROM reservas", conn).ExecuteScalar());
            stats.TotalMensajes  = Convert.ToInt32(new MySqlCommand("SELECT COUNT(*) FROM mensajes", conn).ExecuteScalar());

            // 2. AVG
            var avgPrecio = new MySqlCommand("SELECT COALESCE(AVG(precio), 0) FROM productos", conn).ExecuteScalar();
            stats.PrecioPromedio = Convert.ToDecimal(avgPrecio);

            var avgPers = new MySqlCommand("SELECT COALESCE(AVG(personas), 0) FROM reservas", conn).ExecuteScalar();
            stats.PromedioPersonas = Convert.ToDouble(avgPers);

            // 3. MAX y MIN
            stats.PrecioMaximo = Convert.ToDecimal(new MySqlCommand("SELECT COALESCE(MAX(precio), 0) FROM productos", conn).ExecuteScalar());
            stats.PrecioMinimo = Convert.ToDecimal(new MySqlCommand("SELECT COALESCE(MIN(precio), 0) FROM productos", conn).ExecuteScalar());

            // 4. SUM
            stats.TotalComensales = Convert.ToInt32(new MySqlCommand("SELECT COALESCE(SUM(personas), 0) FROM reservas", conn).ExecuteScalar());

            // 5. GROUP BY con COUNT, AVG, MAX, MIN
            string sqlCat = "SELECT categoria, COUNT(*) AS cant, AVG(precio) AS prom, MAX(precio) AS maxp, MIN(precio) AS minp FROM productos GROUP BY categoria";
            using var cmd = new MySqlCommand(sqlCat, conn);
            using var reader = cmd.ExecuteReader();
            while (reader.Read())
            {
                stats.PorCategoria.Add(new EstadisticaCategoria
                {
                    Categoria = reader.GetString("categoria"),
                    Cantidad = reader.GetInt32("cant"),
                    Promedio = reader.GetDecimal("prom"),
                    Maximo = reader.GetDecimal("maxp"),
                    Minimo = reader.GetDecimal("minp")
                });
            }

            return stats;
        }
    }
}