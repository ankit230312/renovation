<?php
class Home_m extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function hash($string)
    {
        return parent::hash($string);
    }

    function get_banners()
    {
        $this->db->select('*');
        $this->db->from('web_banners');
        $this->db->where('status', 'Y');
        $this->db->order_by("added_on", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_brands()
    {
        $this->db->select('*');
        $this->db->from('brand');
        $this->db->where('is_active', 'Y');
        $this->db->where('is_home', 'Y');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_category()
    {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('status', 'Y');
        $this->db->where('parent!=', '0');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_sub_category()
    {
        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('status', 'Y');
        $this->db->where('parent != ' . '0');
        $this->db->where('parent != ' . '0');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_last_eight_products()
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('featured', 'Y');
        $this->db->order_by("added_on", "DESC");
        $this->db->limit(8);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_gift_banner()
    {
        $this->db->select('*');
        $this->db->from('gift_banner');
        $this->db->where('status', 'Y');
        $this->db->order_by("added_on", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_deal_banner()
    {
        $this->db->select('*');
        $this->db->from('deal_banner');
        $this->db->where('status', 'Y');
        $this->db->order_by("added_on", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_products()
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('in_stock', 'Y');
        $this->db->order_by("added_on", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_cart()
    {
        $this->db->select('*');
        $this->db->from('product_cart');
        $this->db->order_by("added_on", "DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_all_row_where($table, $array, $select = '*')
    {
        $this->db->select($select);
        return $this->db->get_where($table, $array)->result();
    }

    function get_single_row_where($table, $array, $select = '*')
    {
        $this->db->select($select);
        return $this->db->get_where($table, $array)->row();
    }

    public function get_single_table_query($query)
    {
        $query = $this->db->query($query);
        return $query->row();
    }
    public function get_all_table_query($query)
    {
        $query = $this->db->query($query);
        return $query->result();
    }

    function get_single_row($table, $select = '*')
    {
        $this->db->select($select);
        return $this->db->get($table)->row();
    }

    function get_all_row_where_join($table, $array, $join, $select = '*')
    {
        $this->db->select($select);
        foreach ($join as $j) {
            $this->db->join($j['table'], $j['parameter'], $j['position']);
        }
        return $this->db->get_where($table, $array)->result();
    }
    function get_single_row_where_join($table, $array, $join, $select = '*')
    {
        $this->db->select($select);
        foreach ($join as $j) {
            $this->db->join($j['table'], $j['parameter'], $j['position']);
        }
        return $this->db->get_where($table, $array)->row();
    }
    function insert_data($table, $array)
    {
        $this->db->insert($table, $array);
        return $this->db->insert_id();
    }
    function update_data($table, $where, $values)
    {
        $this->db->where($where);
        $this->db->update($table, $values);
        return true;
    }
    function delete_data($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
        return true;
    }
    public function get_single_table($query)
    {
        $query = $this->db->query($query);
        return $query->row();
    }



    public function record_count($table, $where)
    {
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->group_by('productID');
        $this->db->order_by("SUM(qty) DESC");

        $query = $this->db->get($table);

        return  $query->num_rows();
        //        return $this->db->count_all($table);
    }

    public function fetch_products($table, $where, $limit, $start)
    {
        if (!empty($where)) {
            $this->db->where($where);
        }

        $this->db->limit($limit, $start);
        $this->db->group_by('productID');
        $this->db->order_by("SUM(qty) DESC");

        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }





    public function filter_products($limit, $offset, $where = '')
    {
        $sql = "SELECT * FROM `products` WHERE in_stock = 'Y'";
        if ($where != '') {
            $sql .= " AND '$where'";
        }
        if ($limit != '' && $offset != '') {
            $sql .= "LIMIT '$limit' OFFSET '$offset'";
        }
        $products = $this->db->query($sql)->result();
        return $products;
    }

    public function products_count()
    {
        $products = $this->db->query("SELECT * FROM `products` WHERE in_stock = 'Y' ")->result();
        return count($products);
    }
}
